<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsTo('App\Order');
    }
}
