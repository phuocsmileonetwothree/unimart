<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Detail extends Model
{
    protected $table = 'order_details';
    protected $guarded = [];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
