<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard='buyer')
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if( !$user)
                throw new Exception('User Not Found');

            auth()->shouldUse($guard); //shoud you user guard / table
            if( !auth($guard)->user() && auth()->payload()->get('role')!==$guard)
                throw new Exception('Unauthorized');

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
                if( $e->getMessage() === 'Unauthorized') {

                    return response()->json([
                            //User Not guard
                            "data" => null,

                            "status" => false,

                            "err_" => [

                                "message" => "Something error ...".$guard,

                                "code" => 6

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
