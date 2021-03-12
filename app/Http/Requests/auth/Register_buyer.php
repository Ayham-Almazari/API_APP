<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class Register_buyer extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:buyers',
            'last_name' => 'required|string|max:255',
            "phone"=>["required","min:10","numeric","unique:buyers","regex:/^\+9627[789]\d{7}$/"],
            'email' => 'required|string|email|unique:buyers|max:255',
            'password' => ['required','confirmed','min:8','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/']
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
            'password.regex' => ':attribute have at least 1 lowercase AND 1 u ppercase AND 1 number AND 1 symbol',
            'phone.regex' => 'invalid :attribute number.'
        ];
    }
}
