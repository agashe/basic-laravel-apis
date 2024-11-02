<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // we use this special user for testing !!
        User::factory()->create([
            'email' => 'test@example.com',
            'first_name' => "Test",
            'last_name' => "User",
            'birth_date' => "1995-05-20",
            'gender' => "male",
        ]);

        User::factory(100)->create();
    }
}
