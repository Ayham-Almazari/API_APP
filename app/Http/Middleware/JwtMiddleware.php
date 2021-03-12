<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'buyer')
    {


        try {
            auth()->shouldUse($guard); //shoud you user guard / table
            if( !auth($guard)->user() && auth()->paylaoad()->get('role')!==$guard)
                throw new Exception('Unauthorized');

            $user = JWTAuth::parseToken()->authenticate($request,[$guard]);
            if( !$user)
                throw new Exception('User Not Found');

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json([
                        //Token Invalid
                        'data' => null,

                        'status' => false,

                        'err_' => [

                            'message' => 'Something error ...',

                            'code' => 1

                        ]

                    ]

                );

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json([
                        //Token Expired
                        'data' => null,

                        'status' => false,

                        'err_' => [

                            'message' => 'Something error ...',

                            'code' =>2

                        ]

                    ]

                );

            }

            else{

                if( $e->getMessage() === 'User Not Found') {

                    return response()->json([
                            //User Not Found
                            "data" => null,

                            "status" => false,

                            "err_" => [

                                "message" => "Something error ...",

                                "code" => 3

                            ]

                        ]

                    ); }

                return response()->json([
                        //Authorization Token not found
                        'data' => null,

                        'status' => false,

                        'err_' => [

                            'message' => 'Something error ...',

                            'code' =>4

                        ]

                    ]

                );

            }

        }

        return $next($request);
    }
}
