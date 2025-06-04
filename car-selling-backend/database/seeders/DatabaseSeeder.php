<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'email' => 'admin@gmail.com',
             'password'=> bcrypt('admin12'), // Use bcrypt for password hashing
             'role' => 'admin', // Set role to admin for testing
             ]);
    }
}

