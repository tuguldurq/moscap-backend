<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publisher;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublisherAccountant>
 */
class PublisherAccountantFactory extends Factory
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
            'position' => fake()->randomElement(['ceo', 'coo', 'cfo']),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->email(),
            'bank' => fake()->randomElement(['khaan', 'xac', 'golomt']),
            'account_number' => fake()->bankAccountNumber,
            'publisher_id' => Publisher::all()->random()->id
        ];
    }
}
