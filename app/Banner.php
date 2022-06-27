<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'sliders_banners';
    protected $timestamp = true;
    protected $guarded = [];

    public function image(){
        return $this->morphOne(Image::class, 'relation');
    }
}
