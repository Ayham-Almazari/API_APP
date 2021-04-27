<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Traits\auth\ChangePassword;
use App\Http\Traits\auth\PasswordResetRequest;
use App\Models\Owner;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\API\auth\BaseAuth as Controller;

class OwnerAuth extends Controller
{
    use ChangePassword,PasswordResetRequest;

    private const guard = 'owner';

    public function __construct()
    {
        Auth::shouldUse(self::guard);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Register_request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        try {
            $data=$request->only(['username','email','phone']);
            $data['password']=bcrypt($request->password);
            Upload_property_file:{
                $img = $this->upload_base64_image('owners/property-files',base64: $request->property_file);
                $data['property_file']=$img->uploaded_image;
            }
            $user= Owner::create($data);
            $user->delete();
        }catch (\Exception $e){
            return $this->returnError(["server error"=>[$e->getMessage()]],'Internal server error',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->returnSuccessMessage("the user registered successfully");
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        return $this->Login_By_identifier(new Owner(),$request);
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
        $userData = Owner::whereEmail($code[0]->email)->first();
        // update password
        $userData->update([
            'password'=>bcrypt($request->password),
            'password_rested_at'=>Carbon::now()
        ]);
        // remove verification data from db
        $this->updatePasswordRow($request)->delete();

        // reset password response
        return response()->json([
            'data'=>'Password has been updated successfully.'
        ], Response::HTTP_CREATED);
    }

    //this is a function to get your email from database
    public function validateEmail($email)
    {
        return Owner::where('email', $email)->first();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->refresh_Token(new Owner());
    }
}
