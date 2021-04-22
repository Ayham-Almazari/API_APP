<?php

namespace App\Http\Requests\Owner_Factories_CMS;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
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
            'offer_value'=>'numeric|required',
            'offer_price'=>'numeric|required',
            'offer_description'=>'string|max:996',
            'offer_title'=>'string|max:255',
        ];
    }
}
