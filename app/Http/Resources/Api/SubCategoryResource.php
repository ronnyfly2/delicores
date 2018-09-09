<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

use Hashids;

class SubCategoryResource extends JsonResource
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
        ];

        return $data;
    }
}
