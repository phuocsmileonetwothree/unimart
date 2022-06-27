<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function permission_details(){
        return $this->hasMany(Permission_Detail::class, 'permission_id');
    }
}
