<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard permissions
            'view-dashboard',
            
            // Settings permissions
            'view-settings',
            'create-settings',
            'edit-settings',
            'delete-settings',
            
            // Navigation permissions
            'view-navigation',
            'create-navigation',
            'edit-navigation',
            'delete-navigation',
            
            // Footer permissions
            'view-footer',
            'edit-footer',
            
            // Home page permissions
            'view-home-page',
            'edit-home-page',
            
            // Content permissions
            'view-business',
            'edit-business',
            'view-partners',
            'create-partners',
            'edit-partners',
            'delete-partners',
            'view-contact',
            'edit-contact',
            
            // User management permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role & Permission management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            'assign-roles',
            'assign-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web']
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web']
        );

        $editorRole = Role::firstOrCreate(
            ['name' => 'Editor', 'guard_name' => 'web']
        );

        $viewerRole = Role::firstOrCreate(
            ['name' => 'Viewer', 'guard_name' => 'web']
        );

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole->givePermissionTo([
            'view-dashboard',
            'view-settings',
            'edit-settings',
            'view-navigation',
            'create-navigation',
            'edit-navigation',
            'delete-navigation',
            'view-footer',
            'edit-footer',
            'view-home-page',
            'edit-home-page',
            'view-business',
            'edit-business',
            'view-partners',
            'create-partners',
            'edit-partners',
            'delete-partners',
            'view-contact',
            'edit-contact',
            'view-users',
            'view-roles',
            'view-permissions',
        ]);

        $editorRole->givePermissionTo([
            'view-dashboard',
            'view-navigation',
            'create-navigation',
            'edit-navigation',
            'delete-navigation',
            'view-footer',
            'edit-footer',
            'view-home-page',
            'edit-home-page',
            'view-business',
            'edit-business',
            'view-partners',
            'create-partners',
            'edit-partners',
            'delete-partners',
            'view-contact',
            'edit-contact',
        ]);

        $viewerRole->givePermissionTo([
            'view-dashboard',
            'view-settings',
            'view-navigation',
            'view-footer',
            'view-home-page',
            'view-business',
            'view-partners',
            'view-contact',
            'view-users',
            'view-roles',
            'view-permissions',
        ]);

        // Assign roles to existing users
        $users = User::all();
        foreach ($users as $user) {
            if ($user->email === 'admin@osrdigital.com') {
                $user->assignRole('Super Admin');
            } else {
                $user->assignRole('Admin');
            }
        }
    }
}