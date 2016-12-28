<?php

namespace App;

use Laratrust\LaratrustRole;
use Vinkla\Hashids\Facades\Hashids;

class Role extends LaratrustRole
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission')
            ->select(array('id as permission_id','display_name'));
    }

    public function getRoleIdAttribute()
    {
        return Hashids::encode($this->attributes['role_id']);
    }
}