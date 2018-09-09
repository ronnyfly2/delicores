<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\ProductSubcategoryResource;

use Hashids;

class ProductCategoryResource extends JsonResource
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
            'name' => (string) $this->name,
            'slug' => (string) $this->slug,
            'subcategories' => ProductSubcategoryResource::collection($this->product_subcategories)
        ];

        return $data;
    }
}
