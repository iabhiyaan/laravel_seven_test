<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class Role
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
        $userRole = auth()->user()->role;
        // $segment contains the name after admin. E.g /admin/`segment`.
        // These segment are names in resourceful routes . E.g Route::resource('settings', 'SettingController')
        $segment =  Request::segment(2);
        if ($userRole == 'super-admin') {
            return $next($request);
        }
        $access_levels_string = auth()->user()->access_level;
        $access_levels = explode(',', $access_levels_string);
        if (in_array($segment, $access_levels)) {
            return $next($request);
        }
        return redirect()->route('dashboard')->with('message', 'You dont have admin access');
    }
}
