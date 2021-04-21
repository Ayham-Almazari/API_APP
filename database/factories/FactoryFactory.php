<?php

namespace Database\Factories;

use App\Models\Factory as model;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'factory_name'=>$this->faker->word,
            'logo'=>$this->faker->fileExtension,
            'property_file'=>$this->faker->filePath()
        ];
    }
}
