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
        $code = $this->createCode($email);
        // code is important in send mail
        Mail::to($email)->send(new SendMailreset($code));
    }

    public function createCode($email)  // this is a function to get your request email that there are or not to send mail
    {
        $oldCode = DB::table('password_resets')->where('email', $email)->first();

        if ($oldCode) {
            return $oldCode->code;
        }

        $code = substr(number_format(time() * rand(),0,'',''),0,4);
       while ($ifExistCode = DB::table('password_resets')->where('code', $code)->first()){
           $code = substr(number_format(time() * rand(),0,'',''),0,4);
       }

        $this->saveCode($code, $email);
        return $code;
    }


    public function saveCode($code, $email)  // this function save new password
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'code' => $code,
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
            'status'=>false,
            'error' => 'Email does\'t registered'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
            'status'=>true,
            'data' => 'Reset Email is send successfully, please check your inbox.'
        ], Response::HTTP_OK);
    }


}
