<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Heir>
 */
class HeirFactory extends Factory
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
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'register_number' => fake()->randomLetter(),
            'type' => fake()->randomElement(['father', 'mother', 'brother', 'sister', 'other']),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'file_path' => './unknown.png',
        ];
    }
}
