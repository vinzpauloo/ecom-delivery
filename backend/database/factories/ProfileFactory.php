<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'first_name' => $this->faker()->unique()->sentence(),
            'last_name' => $this->faker()->unique()->sentence(),
            'permit' => $this->faker()->text(),
            'building_number' => $this->faker()->text(),
            'street' => $this->faker()->text(),
            'city' => $$this->faker()->text(),
            'landline' => $this->faker()->text(),
            'mobile' => $this->faker()->number(),
            'link' => $this->faker()->sentence()
        ];
    }
}
