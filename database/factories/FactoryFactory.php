<?php

namespace Database\Factories;

use App\Models\Manufactor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Factory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'factory_name'=>$this->faker->name,
            'logo'=>$this->faker->fileExtension,
            'property_file'=>$this->faker->filePath()
        ];
    }
}
