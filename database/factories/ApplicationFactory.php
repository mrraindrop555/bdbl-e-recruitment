<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cid' => fake()->numberBetween(1000000, 9999999),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'marks' => fake()->numberBetween(40, 90),
            'is_selected' => false
        ];
    }
}
