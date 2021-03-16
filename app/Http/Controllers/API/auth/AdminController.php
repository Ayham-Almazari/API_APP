<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use App\Http\Traits\auth\{ChangePassword, PasswordResetRequest};
use App\Models\Admin;
use App\Http\Requests\auth\{Register_buyer,Login_buyer};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{
    use ChangePassword,PasswordResetRequest;
    private const admin = 'admin';
    public function __construct()
    {
        Auth::shouldUse(self::admin);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request,Buyer $buyer) {//by username
        $if_alredy_found=Admin::where('username',$buyer->username)->get();
        if ($if_alredy_found->count() > 0) {
            return $this->returnError(['username'=>['username has already been taken .']],'already registered',Response::HTTP_ALREADY_REPORTED);
        }
        //create Admin from buyer data
        $admin=collect($buyer->getAttributes())->except('id','created_at','updated_at')->toArray();
        //set temporary admin info to pass to an observer created method
        $admin_profile=collect($buyer->profile)->except(['id','admin_id','owner_id','buyer_id'])->toArray();
        \request()->profile=$admin_profile;
        //delete buyer and his profile
        $buyer->delete();
        $admin= Admin::create($admin);
        return $this->returnSuccessMessage('Admin registered successfully');
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

        return $this->respondWithToken($token,auth()->user(),'successfully logged in');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponsea
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


    // Reset password
    private function resetPassword($request) {
        // find email
        $userData = Admin::whereEmail($request->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password)
        ]);
        // remove verification data from db
        $this->updatePasswordRow($request)->delete();

        // reset password response
        return response()->json([
            'data'=>'Password has been updated.'
        ], Response::HTTP_CREATED);
    }


    //this is a function to get your email from database
    public function validateEmail($email)
    {
        return !!Admin::where('email', $email)->first();
    }



}

