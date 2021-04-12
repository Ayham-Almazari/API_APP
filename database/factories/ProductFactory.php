<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "product_name"=>$this->faker->words,
            "product_description"=>$this->faker->text,
            "product_picture"=>$this->faker->imageUrl('200','200'),
            "availability"=>$this->faker->boolean,
        ];
    }
}
