<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $timestamp = true;
    protected $guarded = [];


    public function order_details(){
        return $this->hasMany(Order_Detail::class, 'order_id');
    }
}
