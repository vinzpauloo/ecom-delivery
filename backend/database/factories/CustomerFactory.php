<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {

        return [
            'user_id' => User::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'mobile' => fake()->e164PhoneNumber(),
            'email' => fake()->email(),
            'email_verified_at' => fake()->dateTime(),
            'photo' => fake()->e164PhoneNumber().'customer.jpg'
        ];
    }
}
