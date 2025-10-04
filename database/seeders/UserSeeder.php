<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SuperVisor One',
            'email' => 'supervisor1@gmail.com',
            'phone' => '123456789',
            'role' => \App\Enums\UserRole::SuperVisor,
            'password' => Hash::make('123456'),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Manger One',
            'email' => 'manager1@gmail.com',
            'phone' => '12345678910',
            'role' => \App\Enums\UserRole::Manager,
            'password' => Hash::make('123456'),
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Employee One',
            'email' => 'employee1@gmail.com',
            'phone' => '1234567890',
            'role' => \App\Enums\UserRole::Employee,
            'password' => Hash::make('123456'),
            'is_active' => true,
        ]);
    }
}
