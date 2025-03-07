<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $employeeRole = Role::create(['name' => 'employee']);
        $userRole = Role::create(['name' => 'user']);

        // Define permissions
        $permissions = [
            'manage users',
            'edit profile',
            'view reports',
            'delete users'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(['manage users', 'delete users', 'view reports']);
        $employeeRole->givePermissionTo(['edit profile']);
        $userRole->givePermissionTo(['edit profile']);
    }
    }

