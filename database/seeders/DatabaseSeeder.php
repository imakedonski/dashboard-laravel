<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::factory()->create([
            'name' => 'Ilian Makedonski',
            'email' => 'ilian.makedonski@gmail.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Demo',
            'email' => 'demo@demo.com',
            'password' => 'password',
        ]);

        // Colors
        $this->call([
            ColorsSeeder::class,
        ]);
    }
}
