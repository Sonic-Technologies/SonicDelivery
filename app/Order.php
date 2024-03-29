<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsTo('App\Customer');
    }

    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
