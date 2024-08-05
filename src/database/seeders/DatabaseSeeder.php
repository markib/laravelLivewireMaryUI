<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' =>  env('SEEDER_USER_NAME', 'John Doe'),
            'email' => env('SEEDER_USER_EMAIL', 'test@test.com'),
            'password' => Hash::make((env('SEEDER_USER_PASSWORD', 'password'))),
        ]);
    }
}
