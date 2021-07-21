<?php

namespace App\Http\Middleware;
use Validator;
use Closure;

class StaffsApi
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
        $api_token = $request->header('api_token');
        $data['api_token'] = $api_token;
        $validation = Validator::make($data,[
            'api_token' => 'required|exists:staffs,api_token'
        ],[
            'api_token.required' => "Missing Api Key",
            'api_token.exists' => "Invalid Api Key"
        ]);

            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()],401);
            }

        return $next($request);
    }
}
