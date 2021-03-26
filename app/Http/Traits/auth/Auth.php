<?php


namespace App\Http\Traits\auth;


use App\Models\Buyer;
use App\Models\Owner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

trait Auth
{

    /**
     * log the user to be authenticated by one if his identifies.
     *
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login_By_identifier($model, $request)
    {
        Declaration :{
        $identifiers = [
            ['email', 'password'],
            ['phone', 'password'],
            ['username', 'password']
        ];
        $user = '';
    }
        //iterate the identifies to determine what identifier to use to login
        foreach ($identifiers as list($identifier, $password)) :
            //if the input email
            if ($identifier === 'email')             //if valid email
                $user = $this->get_user_by_email($model, $request);
            //if the input phone
            if ($identifier === 'phone')             //if valid phone
                $user = $this->get_user_by_phone($model, $request);
            //if the input username
            if ($identifier === 'username')           //if valid username
                $user = $this->get_user_by_username($model, $request);
            //if any error
            if ($user instanceof JsonResponse) return response($user->original, Response::HTTP_UNPROCESSABLE_ENTITY);


            //set $credentials
            $credentials = array_combine([$identifier, $password], array_values($request->only('identifier', 'password')));
            //authenticate $credentials
            $token = $this->authenticate_user($model, $user, $credentials, $request,$identifier);//authenticate
            //if authenticated
            if ($token) // if user exists
                return $this->respondWithToken($token, $this->get_data(['identifier','expire'], [$identifier,$request->remember_me ? 20160 : 1440]), 'successfully logged in');
        endforeach;
    }

    /**
     * if the user found by email.
     *
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse or model object
     */
    public function get_user_by_email($model, $request)
    {
        $user = false;
        if (filter_var((string)$request->identifier, FILTER_VALIDATE_EMAIL) || preg_match('/(.com)+/', (string)$request->identifier)) {
            $user = $model::withTrashed()->where('email', $request->identifier)->first();
            if ($user) if ($user->trashed()) return $this->if_not_authorize($request, $model, $user);
            if (!$user) return $this->returnError(['email' => 'Invalid email']);
            if (!Hash::check($request->password, $user->password)) return $this->returnError(['password' => 'Invalid password']);
        }
        return $user;
    }

    /**
     * if the user authorize to login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function if_not_authorize($request, $model, $userTrashed)
    {
        if ($userTrashed->trashed() &&
            $userTrashed instanceof Owner &&
            ($userTrashed->account_verification == "under verification" ||
                $userTrashed->account_verification == "canceled"))
            return $this->
            returnErrorMessage("Please wait to confirm your registration info , your account status : " .
                $userTrashed->account_verification);
    }

    /**
     * if the user found by phone.
     *
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse or model object
     */
    public function get_user_by_phone($model, $request)
    {
        $user = false;
        if (preg_match('/^\+9627[789]\d{7}$/', $request->identifier) or preg_match('/^[0-9]*$/', $request->identifier) or preg_match('/^\+[0-9]*$/', $request->identifier)) {
            $user = $model::withTrashed()->where('phone', $request->identifier)->first();
            if ($user) if ($user->trashed()) return $this->if_not_authorize($request, $model, $user);
            if (!$user) return $this->returnError(['phone' => 'Invalid phone']);
            if (!Hash::check($request->password, $user->password)) return $this->returnError(['password' => 'Invalid password']);
        }
        return $user;
    }

    /**
     * log the user to be authenticated by one if his identifies.
     *
     * @param $model
     * @param $user
     * @param $credentials
     * @param $request
     * @return berare token
     */
    public function authenticate_user($model, $user, $credentials, $request,$identifier)
    {
        return $token = $this->guard()->setTTL($request->remember_me ? 20160 : 1440)->claims([
            'identifier'=>$identifier,
            "user" => is_object($user) ? $user->profile->first_name . " " . $user->profile->last_name : null,
            "username" => is_object($user) ? $user->username : null
        ])->attempt($credentials);
    }

    /**
     * helper array to get user data.
     *
     * @param null $kies
     * @param null $values
     * @return array
     */
    public function get_data($kies = null, $values = null)
    {
        $user = collect(auth()->user(), auth()->user()->profile);
        return [
            "user" => $user,
            "additional_data" => !isset($kies) || !isset($values) ? null : array_combine($kies, $values)
        ];
    }

    /**
     * if the user found by username.
     *
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse or model object
     */
    public function get_user_by_username($model, $request)
    {
        $user = false;
        $user = $model::withTrashed()->where('username', $request->identifier)->first();
        if ($user) if ($user->trashed()) return $this->if_not_authorize($request, $model, $user);
        if (!$user) return $this->returnError(['username' => 'Invalid username']);
        if (!Hash::check($request->password, $user->password)) return $this->returnError(['password' => 'Invalid password']);
        return $user;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return $this->returnData($this->get_data(['identifier'], ['token']));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout(true);

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh_Token($model)
    {
        $token = $this->guard()->claims([
            $model->getJWTCustomClaims(),
            "user" => auth()->user()->profile->first_name . " " . auth()->user()->profile->last_name,
            "username" => auth()->user()->username
        ])
            ->refresh();
        return
            $this->respondWithToken(
                $token
                ,
                $this->get_data(['identifier'], ['token'])
            );
    }

}
