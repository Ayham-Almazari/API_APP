<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Factory;
use App\Models\FactoryPermissions;
use App\Models\Offer;
use App\Models\Owner;
use App\Models\Product;
use App\Models\Category;
use App\Models\UsersProfiles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            Owner::factory(6)->create()->each(function ($user) {
                Factory::withoutEvents(function ()use ($user){
                    Factory::factory(2)->create(['owner_id' => $user->id])->each(function ($factory) {
                        FactoryPermissions::create(['factory_id' => $factory->id]);
                        Category::factory(5)->create(['factory_id' => $factory->id])->each(function ($category) {
                            Product::factory(3)->create(['category_id' => $category->id,"warehouse_quantity"=>random_int(10,100)])->each(
                                fn($product)=>Offer::factory(1)->create(['product_id'=>$product->id])
                            );
                        });
                    });
                });
                UsersProfiles::factory(1)->create(['owner_id' => $user->id]);
            });
        });
        Admin::withoutEvents(function () {
            $admin = Admin::create(['email' => "ayham@gmail.com", "phone" => "+962797551921", "username" => "MRmazari98", "password" => Hash::make("123456789")]);
            $admin->profile()->create(["first_name" => "ayham", "last_name" => 'mazary']);
        });
    }
}
