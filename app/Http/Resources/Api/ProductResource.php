<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\BrandResource;
use App\Http\Resources\Api\ProductCategoryResource;
use App\Http\Resources\Api\ProductSubcategoryResource;

use Hashids;
use App\ProductCategory;

class ProductResource extends JsonResource
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


        $product_categories = ProductCategory::where([
            ['product_id', '=', $this->id],
            ['type', '=', 'category'],
            ['state', '=', 1]
        ])->get();

        $product_subcategories = ProductCategory::where([
            ['product_id', '=', $this->id],
            ['type', '=', 'subcategory'],
            ['state', '=', 1]
        ])->get();

        $product_categories_arr = collect();
        foreach ($product_categories as $key => $product_category) {
            $product_subcategories_arr = collect();
            $product_categories_arr[$key] = $product_category->category;
            foreach ($product_subcategories as $product_subcategory) {
                if($product_subcategory->category->category_id == $product_category->category->id)
                    $product_subcategories_arr[] = $product_subcategory->category;

            }
            $product_categories_arr[$key]->product_subcategories = $product_subcategories_arr;
        }

        $data = [
            '_id' => (string) Hashids::encode($this->id),
            'name' => (string) $this->name,
            'slug' => (string) $this->slug,
            'description' => (string) $this->description,
            'price1' => (string) $this->price1,
            'price2' => (string) $this->price2,
            'price3' => (string) $this->price3,
            'brand' => new BrandResource($this->brand),
            'categories' => ProductCategoryResource::collection($product_categories_arr)
        ];

        return $data;
    }
}
