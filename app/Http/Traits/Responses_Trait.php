<?php


namespace App\Http\Traits;


use App\Exceptions\CategoryNotFoundException;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Response;

trait Responses_Trait
{

    public function returnError($errors,$message="The given data was invalid.",$HTTP=Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'status' => false,
            "message"=>$message,
            'errors' => $errors
        ],$HTTP);
    }


    public function returnSuccessMessage($msg = "",$HTTP=Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'msg' => $msg
        ],$HTTP);
    }
    public function returnErrorMessage($msg = "",$HTTP=Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'status' => false,
            'msg' => $msg
        ],$HTTP);
    }

    public function returnData( $value, $key='data',$msg = "",$HTTP=Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
            $key => $value
        ],$HTTP);
    }


    //////////////////
    public function returnValidationError( $validator,$code = "E001")
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

    /**
     * upload base64 image .
     *
     * @param  string $token
     *
     * @return Image
     */
   public function upload_base64_image($directory, $base64, $disk='public', $quality=100) : Image
   {
       Storage::disk($disk)->exists($directory)?null:Storage::disk($disk)->makeDirectory($directory);
       switch ($disk):
           case 'local':  $disk=storage_path('app');break;
           default :$disk=storage_path('app/public');
       endswitch;
       $image_name=uniqid().'-'.now()->timestamp;
       $extension = Str::between($base64, '/', ';base64');
       $upload_path=$disk.'/'.$directory.'/'.$image_name.'.'.$extension;
       $img=  \Image::make($base64)
           ->save($upload_path,  $quality);
       $img->uploaded_image=$directory.'/'.$image_name.'.'.$extension;
           return $img;
    }

    /**
     * update base64 image .
     *
     * @param  string $token
     *
     * @return Image
     */
    public function update_image($image_db,$directory,$base64,$disk='public',$after='/storage/',$quality=100)
    {
        if ($base64) :
                $this->delete_image($image_db,$disk,$after);
                return $this->upload_base64_image($directory,base64: $base64,disk: $disk,quality: $quality);
        else:
            $this->delete_image($image_db,$disk,$after);
            return null;
        endif;
    }

    /**
     * delete base64 image .
     *
     * @param  string $token
     *
     * @return Image
     */
    public function delete_image($image_db,$disk='public',$after='/storage/')
    {
      return  Storage::disk($disk)->delete(Str::after( $image_db,$after));
    }
}
