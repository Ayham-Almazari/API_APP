<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use App\Models\UsersProfiles;
use Illuminate\Database\QueryException;
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
    use Responses_Trait, ChangePassword, PasswordResetRequest ;

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

            $user = Buyer::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>Hash::make($request->post('password'))
            ]);
            $profile= $user->profile()->create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name
            ]);




        return $this->returnSuccessMessage("the user registered successfully" );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Login_buyer $request)
    {

        $identifier=[
            ['email','password'],
            ['phone','password'],
            ['username','password']
        ];
        for ($i=0;$i<=2;$i++){
            //set identifier to loop
            $credentials = array_combine($identifier[$i],array_values($request->only('identifier', 'password')));
            //authenticate $credentials
            $token = $this->guard()->setTTL($request->remember_me?1440:20160)->claims(
                (new Buyer())->getJWTCustomClaims()
            )->attempt($credentials);
            //if authenticated
            if ($token){
                //data
                $data=array_merge(
                    ["user"=> auth()->user()->toArray()],
                    [
                        "profile"=>collect(auth()->user()->profile)->except('admin_id','owner_id'),
                        'identifier'=>$identifier[$i][0]
                    ]
                );
                return $this->respondWithToken($token ,$data,'successfully logged in');
            }
            if($i==2){
                return response()->json([
                    "state"=>false,
                    "error" =>"Invalid Identifier Or Password",
                ]);
            }
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json(['data'=>auth()->user()->profile]);
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
        return Auth::guard(self::guard);
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
