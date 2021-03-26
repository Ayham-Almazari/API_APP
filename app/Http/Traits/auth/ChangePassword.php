<?php


namespace App\Http\Traits\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

trait ChangePassword
{

    public function passwordResetProcess(Request $request){
        $v= Validator::make($request->all(),[
           'code'=>'required|string|max:4',
           'password' => ['required','min:8','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
       ],[
           'password.regex' => ':attribute have at least 1 lowercase AND 1 uppercase AND 1 number AND 1 symbol'
       ]);

        if ($v->fails()) {
            return \response([
                $v->errors()
                ],422);
        }
        return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
    }

    // Verify if token is valid
    private function updatePasswordRow($request){
        return DB::table('password_resets')->where([
            'code' => $request->code
        ]);
    }

    // Token not found response
    private function tokenNotFoundError() {
        return response()->json([
            'error' => 'code is wrong.'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Reset password
    public function resetPassword($request) {
        // find email
        //     $userData = Buyer::whereEmail($request->email)->first();
        // update password
    /*
    $userData->update([
            'password'=>bcrypt($request->password)
        ]);
    */
        // remove verification data from db
    //        $this->updatePasswordRow($request)->delete();

        // reset password response
       /*
       return response()->json([
            'data'=>'Password has been updated.'
        ],Response::HTTP_CREATED);
       */
    }



}
