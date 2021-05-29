<?php

namespace Database\Factories;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Owner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email'=>$this->faker->email,
            "phone"=>$this->faker->phoneNumber,
            'username'=>$this->faker->userName,
            'property_file'=>$this->faker->imageUrl(),
            'password'=>bcrypt('123456789')
        ];
    }
}
