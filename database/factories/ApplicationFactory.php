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
            'class_x_school_name' => fake()->name(),
            'class_x_completion_year' => fake()->numberBetween(1990, 2015),
            'class_x_marks' => [],
            'class_x_avg' => 0.0,
            'class_xii_school_name' => fake()->name(),
            'class_xii_stream' => fake()->randomElement(['science', 'commerce', 'arts']),
            'class_xii_completion_year' => fake()->numberBetween(1990, 2015),
            'class_xii_marks' => [],
            'class_xii_avg' => 0.0,
            'university_or_college_name' => fake()->name(),
            'university_or_college_course_name' => fake()->name(),
            'university_or_college_completion_year' => fake()->numberBetween(1990, 2015),
            'university_or_college_percentage' => 0.0,
            'masters_institution_name' => fake()->name(),
            'masters_course_name' => fake()->name(),
            'masters_completion_year' => fake()->numberBetween(1990, 2015),
            'masters_completion_year' => 0.0,
            'final_score' => fake()->numberBetween(60, 80),
            'is_shortlisted' => false
        ];
    }
}
