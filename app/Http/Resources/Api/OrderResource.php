<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\OrderDetailResource;

use Hashids;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if(!$this->resource)
            return [];

        $data = [
            '_id' => (string) Hashids::encode($this->id),
            'hash' => (string) $this->hash,
            'order_number' => (string) $this->order_number,
            'total' => (string) $this->total,
            'subtotal' => (string) $this->subtotal,
            'igv' => (string) $this->igv,
            'quantity' => (string) $this->quantity,
            'details' => OrderDetailResource::collection($this->details()->active()->get()),
        ];

        return $data;
    }
}
