<?php


namespace App\Http\Controllers\API\auth;


use App\Http\Traits\auth\Auth;
use App\Notifications\EmailVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

class VerificationController extends Controller
{

    public function __construct()
    {
       /* foreach (['buyer','admin','owner']as $guard){
            $user=auth($guard)->user();
            if ($user) {
                \auth()->shouldUse($guard);
                break;
            }
        } */
    }
    /**
     * Verify email
     *
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function verify(Request $request) {
        //validate code
       $v= Validator::make(['code'=>$request->post('code')],['code'=>'required|string|min:4']);
       if ($v->fails()) {
           return $this->returnError($v->errors());
       }
        // check if code exists
        $code = DB::table('email_verification')->where([
            'code' => $request->code
        ]);
        try {
            if ($code->count() == 0) {
                return $this->returnError(["code"=>['INVALID EMAIL VERIFICATION Code']]);
            }

            $code->delete();

            if (!$request->user()->hasVerifiedEmail()) {
                $request->user()->markEmailAsVerified();
            }
        }catch (\Exception $e){
            return \response([$e->getMessage()]);
        }

        return $this->returnSuccessMessage('email verified successfully '.$request->user()->email);
    }

    /**
     * Resend email verification link
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resend() {

        //user email
        $email=auth()->user()->email;
        //if verified
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->returnSuccessMessage('EMAIL ALREADY VERIFIED');
        }
        //set Code
        $code = substr(number_format(time() * rand(),0,'',''),0,4);
        while ($ifExistCode = DB::table('email_verification')->where('code', $code)->first()){
            $code = substr(number_format(time() * rand(),0,'',''),0,4);
        }

        //if click resend without delete it from verification function
        $ifExistCode = DB::table('email_verification')->where('email', $email);
        $ifExistCode?$ifExistCode->delete():null;

        //insert code
        DB::table('email_verification')->insert([
            'email' => $email,
            'code' => $code,
            'created_at' => Carbon::now()
        ]);

        auth()->user()->notify(new EmailVerify(auth()->user()->profile,$code));

        return $this->returnSuccessMessage("Email verification link sent on your email : ".auth()->user()->email ."  $code ");
    }

    //notice
    public function notice(){
        return $this->returnError(['Email'=>'The user email must verified'],'Email verification error');
    }
}
