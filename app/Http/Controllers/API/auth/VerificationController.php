<?php


namespace App\Http\Controllers\API\auth;


use App\Http\Traits\Responses_Trait;
use App\Notifications\EmailVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController
{
    use Responses_Trait;
    /**
     * Verify email
     *
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function verify(Request $request) {


        try {
            if (! $request->hasValidSignature()) {
                return $this->returnError('INVALID EMAIL VERIFICATION_URL');
            }

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

        if (auth()->user()->hasVerifiedEmail()) {
            return $this->returnSuccessMessage('EMAIL ALREADY VERIFIED');
        }

        //set Code
        $code = substr(uniqid(),0,4);
        while ($ifExistCode = DB::table('email_verification')->where('code', $code)->first()){
            $code = substr(number_format(time() * rand(),0,'',''),0,4);
        }

        //if click resend without delete it from verification function
        $ifExistCode = DB::table('email_verification')->where('email', $email);
        $ifExistCode?$ifExistCode->delete():null;

        //insert code
        DB::table('password_resets')->insert([
            'email' => $email,
            'code' => $code,
            'created_at' => Carbon::now()
        ]);

        auth()->user()->notify(new EmailVerify(auth()->user()->profile,$code));

        return $this->returnSuccessMessage("Email verification link sent on your email : ".auth()->user()->email);
    }

    //notice
    public function notice(){
        return $this->returnError(['Email'=>'The user email must verified'],'Email verification error');
    }
}
