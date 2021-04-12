<?php

namespace Database\Factories;

use App\Models\Users_Profiles;
use App\Models\UsersProfiles;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersProfilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsersProfiles::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name'=>$this->faker->firstName,
            'last_name'=>$this->faker->lastName
        ];
    }
}
