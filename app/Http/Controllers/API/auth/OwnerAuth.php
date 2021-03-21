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
            $data['password']=Hash::make($request->post('password'));
            if ($request->hasFile('property_file'))
                if ($request->file('property_file')->isValid())
                    $data['property_file'] = $request->file('property_file')->store('property_files');
                else
                    $this->returnError(['property_file'=>'Invalid file'],'The file uploaded invalid',Response::HTTP_BAD_REQUEST);

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
        return !!Owner::where('email', $email)->first();
    }
}