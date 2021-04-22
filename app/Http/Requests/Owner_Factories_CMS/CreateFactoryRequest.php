<?php

namespace App\Http\Requests\Owner_Factories_CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateFactoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validate_base64=['base64image',
            function($attribute, $value, $fail){
                $extension = Str::between($value, '/', ';base64');
                if (!in_array($extension,['jpg','gif','jpeg','png','webp'])) {
                    $fail("The $attribute must be a file of type: jpg,png,jpeg,webp,gif.");
                }
            },'base64dimensions:min_width=100,min_height=200'];
        array_unshift($validate_base64,'bail','required');
        $create= [
            "factory_name"  =>'required|min:3|string|alpha_dash|max:255',
            'property_file' => $validate_base64
        ];
        if ($this->isMethod('post'))
            return $create;
        unset($create['property_file']);
        array_shift($validate_base64);
        array_shift($validate_base64);
        array_unshift($validate_base64,'bail','nullable');
        $update=array_merge($create,[
            'logo'         =>$validate_base64,
            'cover_photo'  =>$validate_base64,
            'facebook'     =>'min:3|string|max:255',
            'instagram'    =>'min:3|string|max:255',
            "phone"        =>["min:11","numeric","regex:/^\+9627[789]\d{7}$/"],
            'address'      =>'string|max:255',
            'Description'  =>'string|max:996'
        ]);
        if($this->isMethod('put'))
            return $update;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.regex' => 'invalid :attribute number must be in format : +962 7(7|8|9) ddd dddd .',
        ];
    }
}
