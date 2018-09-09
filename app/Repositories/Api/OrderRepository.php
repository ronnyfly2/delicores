<?php

namespace App\Repositories\Api;

use App\DeliveryPrice;
use App\Order;
use App\OrderDetail;
use App\PaymentType;
use App\Product;

use App\Repositories\RepositoryBase;

class OrderRepository extends RepositoryBase
{
    private $guest = false;

    // Constructor to bind model to repo
    public function __construct()
    {
        $prefix = request()->route()->getPrefix();
        if($prefix == 'api/guest')
            $this->guest = true;
    }

    // Get all instances of model
    public function index()
    {
        return Order::active()->get();
    }

    // show the record with the given id
    public function show($_hash = false)
    {

        $user = false;
        if(!$this->guest)
            $user = request()->user();

        if($user) {
            $order = Order::where([
                ['open', '=', 1]
            ])->active()->first();

            if(!$order)
                $order = Order::create([
                    'hash' => md5(time() . rand( 1, 1000000 )),
                    'user_id' => $user->id,
                    'user_type' => $user->type,
                    'order_number' => 'DL-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)
                ]);
            else {

                $order->user_type = $user->type;

                $order->save();
            }
        } else {

            if($_hash) {
                $order = Order::where([
                    ['hash', '=', $_hash],
                    ['open', '=', 1]
                ])->active()->first();

                if(!$order || $order->user_id > 0)
                    throw new \Exception(_i("Pedido inválido."), 400);

            } else
                $order = Order::create([
                    'hash' => md5(time() . rand( 1, 1000000 )),
                    'order_number' => 'DL-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)
                ]);
        }

        $order = $this->setOrderInfo($order);

        return $order->fresh();
    }

    public function close(array $order_data, array $delivery_price_data, array $payment_type_data, $_hash)
    {

        $order_info = $this->validateOrder($_hash);

        $order = $order_info['order'];

        $order_details = $order->details()->active()->get();

        if($order_details->count() == 0)
            throw new \Exception(_i("Su pedido esta vacio."), 400);


        $order->user_name = $order_data['name'];
        $order->user_last_name = $order_data['last_name'];
        $order->user_email = $order_data['email'];
        $order->user_phone = $order_data['phone'];
        $order->user_address = $order_data['address'];

        $order->user_address_latitude = $order_data['latitude'];
        $order->user_address_longitude = $order_data['longitude'];


        $delivery_price = $this->find(new DeliveryPrice(), $delivery_price_data['_id']);

        $order->delivery_price_id = $delivery_price->id;
        $order->delivery_price_name = $delivery_price->name;
        $order->delivery_price_price = $delivery_price->price;


        $payment_type = $this->find(new PaymentType(), $payment_type_data['_id']);

        $order->payment_type_id = $payment_type->id;
        $order->payment_type_name = $payment_type->name;


        $order->open = 0;

        $order->save();

        return $order->fresh();

    }

    // create a new record in the database
    public function storeDetail(array $data, $_hash)
    {

        $order_info = $this->validateOrder($_hash);

        $order = $order_info['order'];

        $product = $this->find(new Product(), $data['_id']);

        $price = $this->getProductPriceByUser($product, $order_info['user_type']);

        $order_detail = OrderDetail::where([
            ['product_id', '=', $product->id],
            ['order_id', '=', $order->id]
        ])->active()->first();

        if(!$order_detail)
            $order_detail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
            ]);


        $order_detail->quantity += $data['quantity'];
        $order_detail->price = $price;
        $order_detail->total = $order_detail->quantity * $price;
        $order_detail->save();

        $order = $this->setOrderInfo($order);

        return $order->fresh();
    }

    public function updateDetail(array $data, $_hash, $_detail_hash)
    {

        $order_info = $this->validateOrder($_hash);
        $order = $order_info['order'];

        $order_detail = $this->find(new OrderDetail(), $_detail_hash, true, false);

        if(!$order_detail || $order_detail->order_id != $order->id )
            throw new \Exception(_i("El item a editar no es válido."), 400);

        $product = $this->find(new Product(), $order_detail->product_id, false, false);
        if(!$product) {

            $this->deleteDetail($_hash, $_detail_hash);

            throw new \Exception(_i("El producto a actualizar no se encuentra disponible, por lo tanto se ha eliminado del carrito."), 400);

        } else {

            $price = $this->getProductPriceByUser($product, $order_info['user_type']);

            $order_detail->quantity = $data['quantity'];
            $order_detail->price = $price;
            $order_detail->total = $order_detail->quantity * $price;
            $order_detail->save();

            $order = $this->setOrderInfo($order);

            return $order->fresh();
        }
    }

    public function deleteDetail($_hash, $_detail_hash)
    {

        $order_info = $this->validateOrder($_hash);
        $order = $order_info['order'];

        $order_detail = $this->find(new OrderDetail(), $_detail_hash, true, false);

        if(!$order_detail || $order_detail->order_id != $order->id )
            throw new \Exception(_i("El item a eliminar no es válido."), 400);

        $order_detail->state = 3;
        $order_detail->save();

        $order = $this->setOrderInfo($order);

        return $order->fresh();
    }








    private function validateOrder($_hash)
    {

        $user = false;
        $type = 'U';
        if(!$this->guest) {
            $user = request()->user();
            $type = $user->type;
        }

        $order = Order::where([
            ['hash', '=', $_hash],
            ['open', '=', 1],
        ])->active()->first();

        if(!$order)
            throw new \Exception(_i("Pedido invalido"), 400);

        if($this->guest && $order->user_id > 0)
            throw new \Exception(_i("Pedido invalido"), 400);

        if(!$this->guest && $order->user_id != $user->id)
            throw new \Exception(_i("Pedido invalido"), 400);


        return [
            'order' => $order,
            'user_type' => $type
        ];
    }

    private function setOrderInfo($order)
    {

        $order_details = $order->details()->active()->get();
        foreach ($order_details as $order_detail) {

            $product = $this->find(new Product(), $order_detail->product_id, false, false);
            if(!$product) {

                $order_detail->state = 3;

                $order_detail->save();

            } else {

                $price = $this->getProductPriceByUser($product, $order->user_type);

                $order_detail->price = $price;
                $order_detail->total = $order_detail->quantity * $price;

                $order_detail->save();
            }
        }

        $order_details = $order->details()->active()->get();

        $order->total = $order_details->sum('total');
        $order->quantity = $order_details->sum('quantity');
        $order->subtotal = number_format($order->total / 1.18, 2, '.', '');
        $order->igv = $order->total - $order->subtotal;

        $order->save();

        return $order;
    }

    private function getProductPriceByUser($product, $user_type = 'U')
    {

        if($user_type == 'U')
            $price = $product->price1;
        else if ($user_type == 'P')
            $price = $product->price2;
        else if ($user_type == 'C')
            $price = $product->price3;

        return $price;
    }
}
