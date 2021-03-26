<?php


namespace App\Http\Traits\auth;
use App\Notifications\PasswordReset;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;
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
        $email="";
        if(is_array($request->email)) $email=$request->email['email'];
        if(is_string($request->email)) $email=$request->email;

        if (!$this->validateEmail($email)) {  // this is validate to fail send mail or true
            return $this->failedResponse();
        }
        $this->send($email);  //this is a function to send mail
        return $this->successResponse();
    }


    //this is a function to send mail
    public function send($email)
    {
        $code = $this->createCode($email);
        // code is important in send mail
//        Mail::to($email)->send(new SendMailreset($code));
        $user=$this->validateEmail($email);
        $user->notify(new PasswordReset($code));

//        return \response(['code'=>$code],Response::HTTP_OK);
    }

    public function createCode($email)  // this is a function to get your request email that there are or not to send mail
    {
        $oldCode = DB::table('password_resets')->where('email', $email)->first();

        $code = substr(number_format(time() * rand(),0,'',''),0,4);
       while ($ifExistCode = DB::table('password_resets')->where('code', $code)->first()){
           $code = substr(number_format(time() * rand(),0,'',''),0,4);
       }
        if ($oldCode) {
            DB::table('password_resets')->where('email', $email)->update([
                'code'=>$code
            ]);
            return $code;
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
