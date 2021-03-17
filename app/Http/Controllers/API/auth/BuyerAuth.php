<?php

namespace App\Http\Controllers\API\auth;

use App\Models\Buyer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Psy\Exception\TypeErrorException;
use App\Http\Requests\auth\{LoginRequest, RegisterRequest};
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\auth\BaseAuth as Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\auth\{ChangePassword,PasswordResetRequest};
use Symfony\Component\HttpFoundation\Response;
class BuyerAuth extends Controller
{
    use  ChangePassword, PasswordResetRequest ;

    private const guard = 'buyer';

    public function __construct()
    {
        Auth::shouldUse(self::guard);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        try {
            $data=$request->only(['username','email','phone']);
            $data['password']=Hash::make($request->post('password'));
            Buyer::create($data);
        }catch (TypeErrorException $e){
                return $this->returnError(["server error"=>[$e->getMessage()]],'Internal server error',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->returnSuccessMessage("the user registered successfully" );
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->Login_By_identifier(new Buyer(),$request);

    }


    protected function guard(){
        return Auth::guard(self::guard);
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
        return !!Buyer::where('email', $email)->first();
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->refresh_Token(new Buyer());

    }



}
