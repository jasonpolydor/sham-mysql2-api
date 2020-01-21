<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthBasic
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
        // Http basic authentication without setting a
        // user identifier cookie in the session
        // if user if not authenticated
        if(Auth::onceBasic()){
            return response()->json(['message' => 'Auth failed'], 401);
        }else{
            return $next($request);
        }
    }
}
