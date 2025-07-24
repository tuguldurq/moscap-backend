<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'citizen' => fake()->randomElement(['mongolia', 'us', 'canada']),
            'password' => '$2y$10$9Ck6IaEdVDHWNOKX7cN8QuSIuQOKAMtC5qAs28IsFOeK5dbyQOGbe', // password
            'sex' => fake()->randomElement(['male', 'female', 'other']),
            'register_number' => fake()->unique()->randomLetter(),
            'phone' => fake()->unique()->phoneNumber(),
            'role' => 'artist',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
