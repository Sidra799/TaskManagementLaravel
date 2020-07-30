<?php

namespace TaskManagementApp\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessToken = session()->get('access_token');
        if ($accessToken) {
            return $next($request);
        } else {
            Session::flash('error', "Please login first");
            return Redirect::route('login');
        }
    }
}
