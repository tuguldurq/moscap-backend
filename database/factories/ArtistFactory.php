<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ipi_code' => fake()->randomNumber(),
            'type' => fake()->randomElement(['A', 'C', 'AC']),
            'mgl_code' => fake()->randomNumber(),
            'user_id' => User::factory(),
        ];
    }
}
