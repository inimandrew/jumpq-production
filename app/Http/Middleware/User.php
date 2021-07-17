<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class User
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
        if (empty(Auth::guard('user')->user()) | empty(Auth::guard('user')->user()->api_token)){
            return redirect()->route('sign_in')->withErrors(['error' => "You're not Authorised to access this page. Log in "]);
             }
        return $next($request);
    }
}
