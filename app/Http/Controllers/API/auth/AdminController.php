<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Admin;
use App\Models\Buyer;
use App\Http\Requests\buyerauth\{ Register_buyer,Login_buyer};
use App\Http\Traits\Responses_Trait;
use http\Env\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\PayloadException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AdminController extends Controller
{
    use Responses_Trait;
    private const admin = 'admin';


    public function __construct()
    {

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Register_buyer $request) {
        $user = new Admin([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->post('password'))
        ]);
        $user->save();
        return $this->returnSuccessMessage("the user registered successfully");
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login_buyer $request)
    {
        $credentials = $request->only('email', 'password');
        if (! $token = $this->guard()->claims((new Admin())->getJWTCustomClaims())->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token,\auth()->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json(['data'=>auth()->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout(true);

        return response()->json([
            'status'=>true,
            'message' => 'Successfully logged out'
        ],200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $token= $this->guard()->claims((new Admin())->getJWTCustomClaims())
            ->refresh();
        return
            $this->respondWithToken(
                $token
                ,
                JWTAuth::user()
            );
    }



    private function guard(){
        return Auth::guard(self::admin);
    }

}

