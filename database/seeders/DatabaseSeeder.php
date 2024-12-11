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
            'name' => 'Yeeden',
            'email' => 'yeedenr.zimba@bdb.bt',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Yonten',
            'email' => 'yonten351@bdb.bt',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Kinley Zangmo',
            'email' => 'kinley.zangmo@bdb.bt',
            'password' => 'password'
        ]);
        // Vacancy::factory(2)->create(['status' => 'Open'])
        //     ->each(function (Vacancy $vacancy) {
        //         Application::factory(fake()->numberBetween(0, 30))->create(['vacancy_id' => $vacancy->id]);
        //     });
    }
}
