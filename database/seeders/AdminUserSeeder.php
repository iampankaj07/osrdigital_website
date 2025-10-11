<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create comprehensive permissions for superadmin
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
            
            // News management
            'view-news',
            'create-news',
            'edit-news',
            'delete-news',
            'publish-news',
            
            // Film Portfolio management
            'view-film-portfolios',
            'create-film-portfolios',
            'edit-film-portfolios',
            'delete-film-portfolios',
            
            // Team management
            'view-team-members',
            'create-team-members',
            'edit-team-members',
            'delete-team-members',
            
            // Testimonials management
            'view-testimonials',
            'create-testimonials',
            'edit-testimonials',
            'delete-testimonials',
            
            // Associates management
            'view-associates',
            'create-associates',
            'edit-associates',
            'delete-associates',
            
            // Trusted Partners management
            'view-trusted-partners',
            'create-trusted-partners',
            'edit-trusted-partners',
            'delete-trusted-partners',
            
            // System permissions
            'view-logs',
            'clear-cache',
            'backup-database',
            'restore-database',
            'system-maintenance',
            
            // File management
            'upload-files',
            'delete-files',
            'manage-media',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Super Admin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'web'],
            [
                'description' => 'Full access to all features and settings',
                'guard_name' => 'web'
            ]
        );

        // Create admin user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@osr.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
            ]
        );

        // Assign all permissions to Super Admin role
        $superAdminRole->syncPermissions($permissions);

        // Assign Super Admin role to user
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }

        // Create additional admin users for testing
        $additionalAdmins = [
            [
                'name' => 'Admin User',
                'email' => 'admin@osrdigital.com',
                'password' => Hash::make('admin123456'),
            ],
            [
                'name' => 'System Administrator',
                'email' => 'system@osr.com',
                'password' => Hash::make('system123456'),
            ]
        ];

        foreach ($additionalAdmins as $adminData) {
            $adminUser = User::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => $adminData['password'],
                    'email_verified_at' => now(),
                ]
            );

            if (!$adminUser->hasRole('Super Admin')) {
                $adminUser->assignRole('Super Admin');
            }
        }

        $this->command->info('✅ Super Admin users created/updated successfully!');
        $this->command->info('📧 Primary Admin: admin@osr.com');
        $this->command->info('🔑 Password: admin123456');
        $this->command->info('📧 Secondary Admin: admin@osrdigital.com');
        $this->command->info('🔑 Password: admin123456');
        $this->command->info('📧 System Admin: system@osr.com');
        $this->command->info('🔑 Password: system123456');
        $this->command->info('🔐 All users have Super Admin privileges with full system access');
    }
}
