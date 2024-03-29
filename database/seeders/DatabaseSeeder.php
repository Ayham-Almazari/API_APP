<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   $this->call([
        /*PostSeeder::class,
        Category::class,
        ProductSeeder::class,
        OfferSeeder::class,
        OrdersSeeder::class,
        OrderDetailsSeeder::class*/
        ManufactorSeeder::class,
        BuyerSeeder::class
    ]);
    }
}
