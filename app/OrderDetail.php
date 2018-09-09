<?php

namespace App;

class OrderDetail extends MainModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_name',
        'product_price1',
        'product_price2',
        'product_price3',
        'product_price_type',
        'total',
    ];

    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
