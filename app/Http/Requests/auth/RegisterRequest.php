<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|string|min:5|max:255|unique:buyers|unique:admins|unique:owners|alpha_dash|regex:/[a-zA-Z]{3,}/',
            'last_name' => 'required|string|max:255|min:3',
            "phone"=>["required","min:11","numeric","unique:buyers",'unique:admins','unique:owners',"regex:/^\+9627[789]\d{7}$/"],
            'email' => 'required|string|email|unique:buyers|unique:admins|unique:owners|max:255',
            'password' => ['required','min:8','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
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
            'password.regex' => ':attribute have at least 1 lowercase AND 1 uppercase AND 1 number AND 1 symbol',
            'phone.regex' => 'invalid :attribute number must be in format : +962 7(7|8|9) ddd dddd .',
            'username.regex' => ':attribute must be contain at least 3 chars .'
        ];
    }
}
