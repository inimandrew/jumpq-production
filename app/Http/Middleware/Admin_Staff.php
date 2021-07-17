<?php

namespace App\Http\Middleware;
use Validator;
use Closure;
use App\Rules\Token;

class Admin_Staff
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

        $messages = [
            'api_token.required' => "Missing Api Key",
        ];

        $validation = Validator::make($data,[
            'api_token' => ['required',new Token]
        ],$messages);


            if($validation->fails()){
                return response()->json(['errors' => $validation->errors()],401);
        }

        return $next($request);
    }
}
