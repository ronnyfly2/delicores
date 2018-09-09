<?php

namespace App;

class ProductCategory extends MainModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'category_id', 'type'
    ];

    public function category()
    {
        return $this->hasOne('App\Category','id','category_id');
    }


}
