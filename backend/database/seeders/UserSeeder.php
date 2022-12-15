<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        User::factory()->count(10)->has(Customer::factory()->count(1))->create([
            'user_type' => 'Customer',
        ]);

        User::factory()->count(10)->has(Merchant::factory()->has(Restaurant::factory()->count(1)))->create([
            'user_type' => 'Merchant',
        ]);

        User::factory()->count(10)->has(Rider::factory()->count(1))->create([
            'user_type' => 'Rider',
        ]);


    }
}
