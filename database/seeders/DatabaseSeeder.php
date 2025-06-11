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
     *
     * @return void
     */
    public function run()
    {
    //    \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'admin', // Set a username for the admin user
            'email' => 'admin@gmail.com',
            'password'=> hash::make('Admin12'), // Use bcrypt for password hashing
            'role' => 'admin', // Set role to admin for testing
        ]);
    }
}