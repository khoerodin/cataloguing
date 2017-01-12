<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\PermissionRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer(['layouts.app'], function () {
            if (\Auth::check()) {
                $permissions = PermissionRole::select('permissions.name')
                    ->join('permissions', 'permissions.id', 'permission_role.permission_id')
                    ->join('role_user', 'role_user.role_id', 'permission_role.role_id')
                    ->join('users', 'users.id', 'role_user.user_id')
                    ->where('users.id',  \Auth::user()->id)->distinct()
                    ->get()->toArray();

                $perms = [];
                foreach ($permissions as $key => $value) {
                    $perms[] .= $value['name'];
                }

                $perms = array_flip($perms);
                $perms = array_map(function() { return true; }, $perms);
                \JavaScript::put($perms);
            }            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
