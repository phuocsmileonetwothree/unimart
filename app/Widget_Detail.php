<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget_Detail extends Model
{
    protected $table = 'widget_details';
    protected $guarded = [];
    public $timestamps = true;

    public function widget(){
        return $this->belongsTo(Widget::class, 'widget_id');
    }

    public function details(){
        return $this->hasMany(Widget_Detail::class, 'detail_id');
    }
    public function parent_detail(){
        return $this->belongsTo(Widget_Detail::class, 'detail_id');
    }
}
