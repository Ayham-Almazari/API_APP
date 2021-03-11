<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'buyer_id'=>rand(1,50),
            'owner_id'=>rand(1,50),
            'status'=>array_rand(array_flip(["Shipped", "Cancelled", "In Process"])),
            'comment'=>$this->faker->text
        ];
    }
}
