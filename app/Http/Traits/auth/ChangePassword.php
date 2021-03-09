<?php


namespace App\Http\Traits\auth;

use App\Http\Requests\auth\Login_buyer;
use App\Http\Requests\auth\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

trait ChangePassword
{


    public function passwordResetProcess(Request $request){
       $v= $request->validate([
            'resetToken'=>'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => ['required','confirmed','min:8','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
        ]);
        if ($v->fails()) {
            return \response([$v->errors()]);
        }
        return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
    }

    // Verify if token is valid
    private function updatePasswordRow($request){
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->resetToken
        ]);
    }

    // Token not found response
    private function tokenNotFoundError() {
        return response()->json([
            'error' => 'Either your email or token is wrong.'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Reset password
    private function resetPassword($request) {
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
