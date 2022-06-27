<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $timestamp = true;
    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function images(){
        return $this->morphMany(Image::class, 'relation');
    }

    public function colors(){
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id');
    }
}
