<?php


namespace App\Http\Traits\auth;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Mail\SendMailreset;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait PasswordResetRequest
{
    public function sendEmail(Request $request)  // this is most important function to send mail and inside of that there are another function
    {
        if (!$this->validateEmail($request->email)) {  // this is validate to fail send mail or true
            return $this->failedResponse();
        }
        $this->send($request->email);  //this is a function to send mail
        return $this->successResponse();
    }


    //this is a function to send mail
    public function send($email)
    {
        $token = $this->createToken($email);
        // token is important in send mail
        Mail::to($email)->send(new SendMailreset($token, $email));
    }

    public function createToken($email)  // this is a function to get your request email that there are or not to send mail
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(40);
        $this->saveToken($token, $email);
        return $token;
    }


    public function saveToken($token, $email)  // this function save new password
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }


    //this is a function to get your email from database
    public function validateEmail($email)
    {
        //        return !!Buyer::where('email', $email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
            'data' => 'Reset Email is send successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }
}
