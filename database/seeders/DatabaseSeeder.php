<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        Vacancy::factory(2)->create(['status' => 'Open'])
            ->each(function (Vacancy $vacancy) {
                Application::factory(fake()->numberBetween(0, 30))->create(['vacancy_id' => $vacancy->id]);
            });
    }
}
