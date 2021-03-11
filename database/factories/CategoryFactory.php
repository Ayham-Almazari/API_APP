<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "factory_id"=>rand(1,50),
            "category_id"=>rand(1,50),
            "category_name"=>$this->faker->name,
            "category_description"=>$this->faker->text,
        ];
    }
}
