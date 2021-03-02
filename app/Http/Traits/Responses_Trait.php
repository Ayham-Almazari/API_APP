<?php


namespace App\Http\Traits;


trait Responses_Trait
{

    public function returnError($msg,$errNum="E000")
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg
        ]);
    }


    public function returnSuccessMessage($msg = "")
    {
        return response()->json([
            'status' => true,
            'msg' => $msg
        ]);
    }

    public function returnData( $value, $key='data',$msg = "")
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
            $key => $value
        ]);
    }


    //////////////////
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError( $validator->errors(),$code);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $data = null,$msg='')
    {
        return response()->json([
            "state"=>true,
            "data"=>$data,
            "msg"=>$msg,
            '_token' => $token,
            'token_type' => 'bearer',
        ],200);
    }
}
