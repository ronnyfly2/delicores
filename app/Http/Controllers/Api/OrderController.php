<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\OrderCloseRequest;
use App\Http\Requests\Api\OrderDetailRequest;

use App\Repositories\Api\OrderRepository;

use App\Http\Resources\Api\OrderResource;

class OrderController extends Controller
{

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($_hash = false)
    {
        return $this->buildApiResponse([
            'order' => new OrderResource($this->orderRepository->show($_hash))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(OrderDetailRequest $request, $_hash)
    {
        return $this->buildApiResponse([
            'order' => new OrderResource($this->orderRepository->storeDetail($request->get('product'), $_hash))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDetail(OrderDetailRequest $request, $_hash, $_detail_hash)
    {
        return $this->buildApiResponse([
            'order' => new OrderResource($this->orderRepository->updateDetail($request->get('product'), $_hash, $_detail_hash))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDetail(Request $request, $_hash, $_detail_hash)
    {
        return $this->buildApiResponse([
            'order' => new OrderResource($this->orderRepository->deleteDetail($_hash, $_detail_hash))
        ]);
    }

    public function close(OrderCloseRequest $request, $_hash = false)
    {
        return $this->buildApiResponse([
            'order' => new OrderResource($this->orderRepository->close($request->get('order'), $request->get('delivery_price'), $request->get('payment_type'), $_hash))
        ]);
    }
}
