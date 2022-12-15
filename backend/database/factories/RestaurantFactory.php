<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition()
    {
        $name = fake()->unique()->randomElement(['Mcdonalds','Red Ribbon','Starbucks','Jollibee','BonChon Chicken','Italianis','Chowking','Mang Inasal','Tokyo Tokyo','Yellow Cab Pizza']);
        return [
            'merchant_id' => Merchant::factory(),
            'name' => $name,
            'permit' => fake()->postcode(),
            'building_number' => fake()->buildingNumber(),
            'street' => fake()->streetAddress(),
            'city' => 'Panglao',
            'branch' => fake()->randomElement(['Bil-isan', 'Bolod', 'Danao', 'Doljo', 'Libaong', 'Looc', 'Lourdes', 'Poblacion', 'Tangnan', 'Tawala']),
            'landline' => fake()->tollFreePhoneNumber(),
            'mobile' => fake()->e164PhoneNumber(),
            'photo' => $name.'.jpg',
            'social_link' => fake()->url(),
            'long' => fake()->longitude($min = -180, $max = 180),
            'lat' => fake()->latitude($min = -90, $max = 90)
        ];
    }
}
