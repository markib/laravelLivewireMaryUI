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
        $apiKey = config('services.default');

        User::factory()->create([
            'name' => $apiKey['user']['name'],
            'email' => $apiKey['user']['email'],
            'password' => Hash::make($apiKey['user']['password']),
        ]);
    }
}
