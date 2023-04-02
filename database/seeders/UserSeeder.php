<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin user create
        User::factory()
            ->create([
                'name'  => 'Super Admin',
                'email' => 'super@example.com',
            ])
            ->assignRole('Super Admin');

        // Admin user create
        User::factory()
            ->create([
                'name'  => 'Admin',
                'email' => 'admin@example.com',
            ])
            ->assignRole('Admin');

        // Manager user create
        User::factory()
            ->create([
                'name'  => 'Manager',
                'email' => 'manager@example.com',
            ])
            ->assignRole('Manager');

        // Simple user create
        User::factory()
            ->create([
                'name'  => 'User',
                'email' => 'user@example.com',
            ])->assignRole('User');
    }
}
