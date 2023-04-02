<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleList = [
            'Super Admin',
            'Admin',
            'Manager',
            'User',
        ];

        foreach ($roleList as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
