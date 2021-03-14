<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use App\Models\UsersProfiles;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
            //if the input email
            if ($identifier[$i][0]==='email') {
                //if valid email
                if (filter_var((string)$request->identifier, FILTER_VALIDATE_EMAIL)) {
                    //get user
                    $user=  Buyer::where('email' ,$request->identifier)->first();
                  if (!$user)
                      return $this->returnError(['email'=>'Invalid email']);
                        if (!Hash::check($request->password,$user->password))
                            return $this->returnError(['password'=>'Invalid password']);
                }
            }elseif ($identifier[$i][0]==='phone'){
                if (preg_match('/^\+9627[789]\d{7}$/',$request->identifier) or preg_match('/^[0-9]*$/',$request->identifier) or preg_match('/^\+[0-9]*$/',$request->identifier)) {
                $user=  Buyer::where('phone' ,$request->identifier)->first();
                if (!$user)
                    return $this->returnError(['phone'=>'Invalid phone']);
                if (!Hash::check($request->password,$user->password))
                    return $this->returnError(['password'=>'Invalid password']);
            }
            }
            //set identifier to loop
            $credentials = array_combine($identifier[$i],array_values($request->only('identifier', 'password')));
            //authenticate $credentials
            $token = $this->guard()->setTTL($request->remember_me?20160:1440)->claims(
                (new Buyer())->getJWTCustomClaims()
            )->attempt($credentials);
            //if authenticated
            if ($token){
                return $this->respondWithToken($token ,$this->get_data(['identifier'],[$identifier[$i][0]]),'successfully logged in');
            }
            if($i==2){
                $user=  Buyer::where('username' ,$request->identifier)->first();
                if (!$user)
                    return $this->returnError(['username'=>'Invalid username'],'','');
                if (!Hash::check($request->password,$user->password))
                    return $this->returnError(['password'=>'Invalid password']);
            }
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return $this->returnData($this->get_data());
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
    public function refresh()
    {
        $token= $this->guard()->claims((new Buyer())->getJWTCustomClaims())
            ->refresh();
            return
                $this->respondWithToken(
                    $token
                    ,
                    $this->get_data()
                );
    }



    private function guard(){
        return Auth::guard(self::guard);
    }

    public function get_data($kies=null,$values=null) {
        return [
            "user"=> auth()->user()->toArray(),
             "profile"=>collect(auth()->user()->profile)->except('admin_id','owner_id'),
             "additional_data"=> !isset($kies)||!isset($values)?null:array_combine($kies,$values)
        ];

    }

    // Reset password
    public function resetPassword($request) {
        // find email
        $code = DB::table('password_resets')->where([
            'code' => $request->code
        ])->get();
        $userData = Buyer::whereEmail($code[0]->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password),
            'password_reset_at'=>Carbon::now()
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
