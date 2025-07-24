<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'surname' => fake()->name(),
            'english_name' => fake()->name(),
            'type' => fake()->randomElement(['llc', 'lc']),
            'activity_type' => fake()->randomElement(['film', 'hotel', 'music']),
            'person_name' => fake()->name(),
            'person_position' => fake()->randomElement(['ceo', 'coo', 'cfo']),
            'person_phone' => fake()->phoneNumber(),
            'user_id' => User::all()->random()->id,
        ];
    }
}
