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
                response()->make(["message"=> "Unauthenticated."],\Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN)
            );
        }

        if (!$request->expectsJson()) {
             return route('view.admin.login');
        }

    }
}
