<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionList = [
            'panel: view',
            'user: list',
            'user: view',
            'user: create',
            'user: update',
            'user: delete',
            'role: list',
            'role: view',
            'role: create',
            'role: update',
            'role: delete',
            'permission: list',
            'permission: view',
            'permission: create',
            'permission: update',
            'permission: delete',
            'tenant: list',
            'tenant: view',
            'tenant: create',
            'tenant: update',
            'tenant: delete',
            'domain: list',
            'domain: view',
            'domain: create',
            'domain: update',
            'domain: delete',
        ];

        foreach ($permissionList as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
