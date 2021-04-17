<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCategoryName implements Rule
{
    private $factory;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($factory)
    {
        $this->factory=$factory;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !in_array(strtolower($value), $this->factory->categories()->pluck('category_name')->map(function ($name) {
            return strtolower($name);
        })->all());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute has already been taken .';
    }
}
