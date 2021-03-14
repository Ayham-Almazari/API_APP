<?php


namespace App\Http\Controllers\API\auth;


use App\Http\Traits\Responses_Trait;
use Illuminate\Http\Request;

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

        if (auth()->user()->hasVerifiedEmail()) {
            return $this->returnSuccessMessage('EMAIL ALREADY VERIFIED');
        }

        auth()->user()->sendEmailVerificationNotification();

        return $this->returnSuccessMessage("Email verification link sent on your email : ".auth()->user()->email);
    }

    //notice
    public function notice(){
        return $this->returnError(['Email'=>'The user email must verified'],'Email verification error');
    }
}
