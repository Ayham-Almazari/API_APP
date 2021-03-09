<?php


namespace App\Http\Controllers\API\auth;


use Illuminate\Http\Request;

class VerificationController
{
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

        return $this->returnSuccessMessage('email verified successfully');
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
        auth()->user()->sendEmailVerificationNotification();a

        return $this->returnSuccessMessage("Email verification link sent on your email id");
    }
}
