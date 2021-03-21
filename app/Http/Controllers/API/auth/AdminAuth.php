<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use App\Http\Traits\auth\{ChangePassword, PasswordResetRequest};
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\auth\{LoginRequest};
use App\Http\Controllers\API\auth\BaseAuth as Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth extends Controller
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
    public function register(Buyer $buyer) {//by username
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
        $buyer->forceDelete();
        $admin= Admin::create($admin);
        return $this->returnSuccessMessage('Admin registered successfully');
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
       return $this->Login_By_identifier(new Admin(),$request);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->refresh_Token(new Admin());

    }



    public function guard(){
        return Auth::guard(self::admin);
    }


    // Reset password
    public function resetPassword($request) {
        // find email
        $code = DB::table('password_resets')->where([
            'code' => $request->code
        ])->get();
        $userData = Admin::whereEmail($code[0]->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password),
            'password_rested_at'=>Carbon::now()
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

