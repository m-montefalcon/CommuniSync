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
            'house_no' => $faker->optional()->buildingNumber,
            'family_member' => $faker->optional()->randomDigit,
            'email_verified_at' => now(),
            'manual_visit_option' => $faker->boolean(80), // Adjust the chance of having manual visit option as needed
            'photo' => $faker->imageUrl(), // Generate a placeholder image URL
            'role' => $faker->randomElement([1, 2, 3, 4]),
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Replace 'password' with the desired password
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
