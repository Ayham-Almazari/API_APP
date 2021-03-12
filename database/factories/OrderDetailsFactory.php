<?php

namespace Database\Factories;

use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'=>rand(1,50),
            'product_id'=>rand(1,50),
            'quantity_ordered'=>rand(1,17),
            'price_each'=>$this->faker->randomFloat(2,5,80)
        ];
    }
}
