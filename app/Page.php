<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $guarded = [];

    public function user(){
        return $this -> belongsTo('App\User', 'user_id')->withTrashed();
    }
}
