<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Requests\auth\Login_buyer;
use App\Http\Requests\auth\Register_buyer;
use App\Http\Traits\auth\ChangePassword;
use App\Http\Traits\auth\PasswordResetRequest;
use App\Http\Traits\Responses_Trait;
use App\Models\Factory;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    use Responses_Trait,ChangePassword,PasswordResetRequest;

    private const guard = 'owner';

    public function __construct()
    {
        Auth::shouldUse(self::guard);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Register_buyer $request) {

        $user = new Owner([
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
        if (! $token = $this->guard()->claims((new Factory())->getJWTCustomClaims())->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token,auth()->user(),'successfully logged in');
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
        $token= $this->guard()->claims((new Factory())->getJWTCustomClaims())
            ->refresh();
        return
            $this->respondWithToken(
                $token
                ,
                JWTAuth::user()
            );
    }



    private function guard(){
        return Auth::guard(self::guard);
    }


    // Reset password
    private function resetPassword($request) {
        // find email
        $userData = Factory::whereEmail($request->email)->first();
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
        return !!Owner::where('email', $email)->first();
    }
}
