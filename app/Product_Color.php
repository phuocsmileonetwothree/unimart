<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Color extends Model
{
    protected $guarded = [];
    protected $table = 'product_colors';
    public $timestamps = false;
}
