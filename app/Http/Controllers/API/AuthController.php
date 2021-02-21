<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use http\Env\Response;
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


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request ) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email:rfc,dns|unique:users',
            'password' => 'required|confirmed|min:6|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"=>false,
                "errors"=>$validator->errors()
            ],422);
        }

        $user = new User([
            'name'=>e($request->name),
            'email'=>e($request->email),
            'password'=>bcrypt($request->password)
        ]);
        try {
            $token = $this->guard()->claims(['role'=>'user'])->login($user);
        }catch (TokenInvalidException $e){
            return \response()->json([
                'state'=>false,
                'msg'=>$e->getMessage()
            ]);
        }catch (\Tymon\JWTAuth\Exceptions\InvalidClaimException $e){
            return \response()->json([
                'state'=>false,
                'msg'=>$e->getMessage()
            ]);
        }
        $user->save();
        return $this->respondWithToken($token,$user);


    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6|max:10',
            'remember_me'=>'boolean'
        ]);
        $credentials = $request->only('email', 'password');
        if (! $token = $this->guard()->claims(['role'=>'user'])->attempt($credentials)) {
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
        ],200)->withoutCookie('_token');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token=auth()->refresh(true,true);
        }catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json([
                'state'=>false,
                "msg"=>$e->getMessage()
            ]);
        }
        return $this->respondWithToken(auth()->claims(['role'=>'user'])->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$user = null)
    {
        return response()->json([
            "state"=>true,
            "data"=>$user,
            'access_token' => $token,
            'token_type' => 'bearer'
        ],200)->cookie(
            "_token", $token
        );
    }

    private function guard(){
        return Auth::guard();
    }

}
