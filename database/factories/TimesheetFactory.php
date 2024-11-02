<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'project_id' => fake()->numberBetween(1, 101),
            'user_id' => fake()->numberBetween(1, 101),
            'date' => fake()->date(),
            'hours' => fake()->numberBetween(1, 200),
        ];
    }
}
