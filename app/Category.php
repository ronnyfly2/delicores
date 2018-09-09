<?php

namespace App;

class Category extends MainModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }

    public function subcategories()
    {
        return $this->hasMany('App\Category','category_id','id');
    }
}
