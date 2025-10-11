<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@osr.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123')
            ]
        );

        // Create roles if they don't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // Create permissions if they don't exist
        $permissions = [
            'view-dashboard',
            'manage-pages',
            'manage-content',
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'manage-settings',
            'manage-dynamic-pages',
            'manage-content-blocks'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign Super Admin role to user
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }

        // Assign all permissions to Super Admin role
        $superAdminRole->syncPermissions($permissions);

        $this->command->info('Admin user created/updated: admin@osr.com');
        $this->command->info('Password: password123');
    }
}
