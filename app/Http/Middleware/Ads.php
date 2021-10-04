<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Session;

class Ads
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
        if (!Auth::guard('ads')->check()) {
            Session::put('red', 1);
            return redirect()->route('advert-login')->withErrors(['message' => 'Unauthorised! Please Login']);
        }
        return $next($request);
    }
}