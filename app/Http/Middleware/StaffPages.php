<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class StaffPages
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
        if (empty(Auth::guard('staff')->user()) | empty(Auth::guard('staff')->user()->api_token)){
            return redirect()->route('staff_login')->withErrors(['error' => "You're not Authorised to access this page. Log in "]);
             }
        return $next($request);
    }
}
