<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use App\Http\Requests\auth\{Register_buyer, Login_buyer, UpdatePasswordRequest};
use App\Http\Traits\Responses_Trait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\auth\{ChangePassword,PasswordResetRequest};
use Symfony\Component\HttpFoundation\Response;
class BuyerController extends Controller
{
    use Responses_Trait,ChangePassword,PasswordResetRequest;

    private const guard = 'buyer';

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

        $user = new Buyer([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->post('password'))
        ]);
        $user->save();

        return $this->returnSuccessMessage("the user registered successfully" );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login_buyer $request)
    {
        $credentials = $request->only('email', 'password');
        if (! $token = $this->guard()->claims((new Buyer())->getJWTCustomClaims())->attempt($credentials)) {
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
            'status'  => true,
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
        $token= $this->guard()->claims((new Buyer())->getJWTCustomClaims())
            ->refresh();
            return
                $this->respondWithToken(
                    $token
                    ,
                    JWTAuth::user()
                );
    }



    private function guard(){
        return Auth::guard(self::buyer);
    }



    // Reset password
    private function resetPassword($request) {
        // find email
        $userData = Buyer::whereEmail($request->email)->first();
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
        return !!Buyer::where('email', $email)->first();
    }



}
