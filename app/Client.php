<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    public $timestamps = true;
    protected $guarded = [];
    protected $table = 'clients';    
}
