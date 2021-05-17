<?php

namespace App\Http\Requests\Owner_Factories_CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
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
            'product_name' => ['string','alpha_dash' ,'max:255', 'required'],
            'price'=>'numeric|required',
            'category_id' => 'numeric|required',
            'product_description' => 'required|string|max:996',
            'product_picture' => ['bail','nullable','base64image',
                function($attribute, $value, $fail){
                    $extension = Str::between($value, '/', ';base64');
                    if (!in_array($extension,['jpg','gif','jpeg','png','webp'])) {
                        $fail("The $attribute must be a file of type: jpg,png,jpeg,webp,gif.");
                }
            }],//,'base64dimensions:min_width=100,min_height=200'
            'availability' => 'boolean',
        ];
    }


}
