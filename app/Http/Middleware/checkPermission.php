<?php

namespace TaskManagementApp\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;


class checkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        $permissions_array = explode('|', $permissions);
        foreach ($permissions_array as $permission) {
            if ($this->hasPermission($permission)) {
                return $next($request);
            }
        }
        Session::flash('error', "You don't have this permission");
        return redirect()->back();
    }
    public static function hasPermission($permission)
    {
        $userPermissions = session()->get('permissions');
        foreach ($userPermissions as $userPermission) {
            if ($permission == $userPermission->name) {
                return true;
            }
        }
    }
}
