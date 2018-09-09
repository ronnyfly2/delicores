<?php

namespace App;

class Product extends MainModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'brand_id', 'images', 'description', 'price1', 'price2', 'price3'
    ];

    public function brand()
    {
        return $this->HasOne('App\Brand','id','brand_id');
    }

    public function product_categories()
    {
        return $this->belongsToMany('App\Category', 'product_categories', 'product_id','category_id')->where([
            ['product_categories.state', '=', 1],
            ['categories.state', '=', 1],
            ['product_categories.type', '=', 'category'],
        ]);
    }

    public function product_subcategories()
    {
        return $this->belongsToMany('App\Category', 'product_categories', 'product_id','category_id')->where([
            ['product_categories.state', '=', 1],
            ['categories.state', '=', 1],
            ['product_categories.type', '=', 'subcategory'],
        ]);
    }
}
