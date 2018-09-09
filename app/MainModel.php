<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainModel extends Model
{

    public function scopeActive( $query )
    {
        return $query->where('state', 1);
    }
}
