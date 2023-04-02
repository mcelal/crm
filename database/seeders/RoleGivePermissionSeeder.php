<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleGivePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::findByName('Admin')
            ->givePermissionTo(
                Permission::all()
                    ->pluck('name')
                    ->toArray()
            );

        Role::findByName('Manager')
            ->givePermissionTo([
                'panel: view',
                'user: list',
                'user: create',
                'user: update',
                'role: list',
                'permission: list',
                'tenant: list',
                'tenant: create',
                'tenant: update',
                'domain: list',
                'domain: create',
                'domain: update',
            ]);

        Role::findByName('User')
            ->givePermissionTo([
                'panel: view',
                'user: list',
                'role: list',
                'permission: list',
                'tenant: list',
                'domain: list',
            ]);
    }
}
