<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $timestamp = true;
    protected $guarded = [];
    

    public function child_items()
    {
        return $this->hasMany(Widget::class, 'parent_id');
    }
    
    public function widget_details(){
        return $this->hasMany(Widget_Detail::class, 'widget_id');
    }


}
