<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateUsersProfilesRequest extends FormRequest
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
        return [
            'first_name' => 'required|string|max:255|min:3',
            'username' => 'required|string|min:5|max:255|alpha_dash|regex:/[a-zA-Z]{3,}/',
            'last_name' => 'required|string|max:255|min:3',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            "phone"=>["required","min:11","numeric","regex:/^\+9627[789]\d{7}$/"],
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
            'picture'=>['bail','nullable','base64image',
                function($attribute, $value, $fail){
                    $extension = Str::between($value, '/', ';base64');
                    if (!in_array($extension,['jpg','gif','jpeg','png','webp'])) {
                        $fail("The $attribute must be a file of type: jpg,png,jpeg,webp,gif.");
                    }
                },'base64dimensions:min_width=100,min_height=200']
        ];
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
            'username.regex' => ':attribute must be contain at least 3 chars .'
        ];
    }
}
