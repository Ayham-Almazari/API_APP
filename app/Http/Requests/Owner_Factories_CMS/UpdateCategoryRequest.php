<?php

namespace App\Http\Requests\Owner_Factories_CMS;

use App\Models\Factory;
use App\Rules\UniqueCategoryName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    public $factory;
    public $category;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $factories=auth()->user()->factories;
        $factory=false;
        $category=false;
        if (!$factory=$factories->find(Str::between($this->getRequestUri(),'/api/v1/factories/','/Categories'))) {
            return  false;
        }elseif(!$category=$factories->find(Str::between($this->getRequestUri(),'/api/v1/factories/','/Categories'))->categories->find(Str::after($this->getRequestUri(),'Categories/'))){
            return  false;
        }
        $this->factory=$factory;
        $this->category=$category;
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
            'category_name' => ['string','alpha_dash' ,'required','min:3','max:255', new UniqueCategoryName($this->factory)],
            'category_description' => 'string|max:996'
        ];
    }
}
