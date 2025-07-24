<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArtistManager>
 */
class ArtistManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'artist_id' => Artist::all()->random()->id,
            'name'=> fake()->name(),
            'phone' => fake()->unique()->phoneNumber(),
        ];
    }
}
