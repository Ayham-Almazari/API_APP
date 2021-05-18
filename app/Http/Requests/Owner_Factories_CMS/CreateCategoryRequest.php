<?php

namespace App\Http\Requests\Owner_Factories_CMS;

use App\Models\Factory;
use App\Rules\UniqueCategoryName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryRequest extends FormRequest
{
    public $factory;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->factory=auth()->user()->factories->find($this->route('factory'));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_name' => ['string' ,'min:3','max:255', 'required', new UniqueCategoryName($this->factory)],
            'category_description' => 'string|max:996'
        ];
    }
}
