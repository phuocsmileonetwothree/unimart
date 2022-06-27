<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $guarded = [];
    protected $table = 'memories';
    public $timestamps = false;
}
