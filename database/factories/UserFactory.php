<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
    
        return [
            'user_name' => $faker->unique()->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'contact_number' => $faker->phoneNumber,
            'house_no' => $faker->buildingNumber,
            'family_member' => json_encode([
                $faker->randomElement(['John', 'Jane', 'Michael', 'Emily', 'William', 'Olivia']),
                $faker->randomElement(['John', 'Jane', 'Michael', 'Emily', 'William', 'Olivia']),
                $faker->randomElement(['John', 'Jane', 'Michael', 'Emily', 'William', 'Olivia'])
            ]),
            'email_verified_at' => now(),
            'manual_visit_option' => $faker->boolean(80), 
            'photo' => $faker->imageUrl(), 
            'role' => $faker->randomElement([1, 2, 3]),
            'email' => $faker->safeEmail,
            'password' => bcrypt('password'), 
            'remember_token' => Str::random(10),
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
