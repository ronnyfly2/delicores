<?php

namespace App;

class Order extends MainModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash',
        'user_id',
        'user_type',
        'order_number'
    ];

    public function details()
    {
        return $this->hasMany('App\OrderDetail','order_id','id');
    }
}
