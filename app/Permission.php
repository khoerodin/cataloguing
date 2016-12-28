<?php

namespace App;

use Laratrust\LaratrustPermission;
use Vinkla\Hashids\Facades\Hashids;

class Permission extends LaratrustPermission
{
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function getPermissionIdAttribute()
    {
        return Hashids::encode($this->attributes['permission_id']);
    }
}
