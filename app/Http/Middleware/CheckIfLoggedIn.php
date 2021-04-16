<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $logged_flag=false;
        foreach (['buyer','admin','owner'] as $guard){
            $logged_flag=auth($guard)->check();
            if ($logged_flag) {
                Auth::shouldUse($guard);
                break;
            }
        }

        if($logged_flag == false){
           return response()->json(["unauthenticated ."]);
         }

        return $next($request);
    }
}
