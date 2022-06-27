<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $timestamp = true;
    protected $guarded = [];
    public function category(){
        return $this -> belongsTo(Category::class, 'cat_id');
    }

    public function user(){
        return $this -> belongsTo(User::class, 'user_id')->withTrashed();
    }
}
