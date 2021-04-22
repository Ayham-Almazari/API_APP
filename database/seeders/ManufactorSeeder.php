<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\Offer;
use App\Models\Owner;
use App\Models\Product;
use App\Models\Category;
use App\Models\UsersProfiles;
use Illuminate\Database\Seeder;

class ManufactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Owner::withoutEvents(function () {
            Owner::factory(50)->create()->each(function ($user) {
                Factory::factory(2)->create(['owner_id' => $user->id])->each(function ($factory) {
                    Category::factory(5)->create(['factory_id' => $factory->id])->each(function ($category) {
                        Product::factory(3)->create(['category_id' => $category->id])->each(
                            fn($product)=>Offer::factory(1)->create(['product_id'=>$product->id])
                        );
                    });
                });
                UsersProfiles::factory(1)->create(['owner_id' => $user->id]);
            });
        });

    }
}
