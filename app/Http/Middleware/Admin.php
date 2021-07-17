<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
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
        if (empty(Auth::guard('admin')->user()) | empty(Auth::guard('admin')->user()->api_token)){
            return redirect()->route('admin_login')->withErrors(['error' => "You're not Authorised to access this page. Log in "]);
             }
        return $next($request);
    }
}
