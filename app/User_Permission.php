<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Permission extends Model
{
    protected $guarded = [];
    protected $table = 'user_permissions';
    

    public $timestamps = false;
}
