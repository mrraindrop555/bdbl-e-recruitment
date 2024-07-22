<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position_title' => fake()->jobTitle(),
            'benchmark' => fake()->numberBetween(65, 75),
            'number_of_slots' => fake()->numberBetween(1, 4),
            'close_date' => fake()->date(),
            'employment_type' => fake()->sentences(fake()->numberBetween(2, 6)),
            'qualifications' => fake()->sentences(fake()->numberBetween(2, 6)),
            'salary_and_benefits' => ['Basic salary Nu. ' . fake()->numberBetween(20000, 100000), ...fake()->sentences(fake()->numberBetween(2, 6))],
            'status' => fake()->randomElement(['Open', 'Closed']),
        ];
    }
}
