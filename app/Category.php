<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    protected $timestamp = true;
    // return one level of child items
    public function child_items()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // recursive relationship
    public function all_child_items()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('child_items');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'cat_id')->withTrashed();
    }

    public function products(){
        return $this->hasMany(Product::class, 'cat_id')->withTrashed();
    }

    public function brands(){
        return $this->belongsToMany(Brand::class, 'categories_brands', 'cat_id');
    }

}
