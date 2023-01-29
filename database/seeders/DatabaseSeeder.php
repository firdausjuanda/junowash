<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Firdaus Juanda',
            'email' => 'firdausjuanda06@gmail.com',
            'role' => 'admin',
            'password' => '$2y$10$DIMag76JIUakvykQvmr79u5fzieNZIs7FPR8EQrvSsKU3l2OKL/J2',
            'email_verified_at' => '2022-11-28 02:53:49',
            'active' => 1,
        ]);
        Category::factory()->create([
            [
                'name' => "Motorcycle",
                'active' => 1
            ],
            [
                'name' => "Car",
                'active' => 1
            ],
            [
                'name' => "Truck",
                'active' => 1
            ],
        ]);
        Product::factory()->create([
            [
                'name' => 'Vario',
                'category_id' => 1,
                'brand' => 'Honda',
                'model' => '125X',
                'price'=> 15000,
                'uom' => 'Unit',
            ],
            [
                'name' => 'Mio',
                'category_id' => 1,
                'brand' => 'Yamaha',
                'model' => 'Mio J 2014',
                'price'=> 15000,
                'uom' => 'Unit',
            ],
            [
                'name' => 'Scoopy',
                'category_id' => 1,
                'brand' => 'Honda',
                'model' => '2017',
                'price'=> 15000,
                'uom' => 'Unit',
            ],
            [
                'name' => 'V-ixion',
                'category_id' => 1,
                'brand' => 'Yamaha',
                'model' => '2018',
                'price'=> 20000,
                'uom' => 'Unit',
            ],
        ]);
    }
}
