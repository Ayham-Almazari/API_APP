<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\UsersProfiles;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buyer::withoutEvents(function () {
            Buyer::factory(50)->create()->each(function ($buyer) {
                UsersProfiles::factory(1)->create(['buyer_id' => $buyer->id]);
                $buyer->Cart()->attach(random_int(1,50),['quantity'=>random_int(1,10)]);
            });
        });
    }
}
