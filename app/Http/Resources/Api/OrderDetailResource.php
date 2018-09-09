<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ProductResource;

use Hashids;

class OrderDetailResource extends JsonResource
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

            'quantity' => (string) $this->quantity,
            'product_name' => (string) $this->product_name,
            'total' => (string) $this->total,

            'product' => new ProductResource($this->product),
        ];

        return $data;
    }
}
