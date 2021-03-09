<?php

namespace App\Http\Middleware;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if($request->is('api/*'))
        {
            throw new HttpResponseException(
                response()->make(["message"=> "Unauthenticated."])
            );
        }

        if (!$request->expectsJson()) {
            // return route('login');
            $request->headers->set('Accept', 'application/json');
            return redirect("/login")->with("message", "Exceeded an inactivity period of over 15 mins. Kindly re-login to continue");
        }

    }
}
