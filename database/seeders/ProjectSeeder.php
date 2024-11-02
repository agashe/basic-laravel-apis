<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory(100)->create();

        // add users to projects
        for ($i = 1;$i <= 1000;$i++) {
            DB::table('project_user')->insert([
                'project_id' => fake()->numberBetween(1, 101),
                'user_id' => fake()->numberBetween(1, 101),
            ]);
        }

    }
}
