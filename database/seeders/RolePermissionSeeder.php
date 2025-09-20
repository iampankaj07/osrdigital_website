<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create permissions
        $permissions = [
            // User management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Role management
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Permission management
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Portfolio management
            'portfolios.view',
            'portfolios.create',
            'portfolios.edit',
            'portfolios.delete',

            // News management
            'news.view',
            'news.create',
            'news.edit',
            'news.delete',

            // Pages management
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.delete',

            // Partners management
            'partners.view',
            'partners.create',
            'partners.edit',
            'partners.delete',

            // Contact management
            'contacts.view',
            'contacts.edit',
            'contacts.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'Viewer']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole->givePermissionTo([
            'users.view', 'users.create', 'users.edit',
            'portfolios.view', 'portfolios.create', 'portfolios.edit', 'portfolios.delete',
            'news.view', 'news.create', 'news.edit', 'news.delete',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'partners.view', 'partners.create', 'partners.edit', 'partners.delete',
            'contacts.view', 'contacts.edit', 'contacts.delete',
        ]);

        $editorRole->givePermissionTo([
            'portfolios.view', 'portfolios.create', 'portfolios.edit',
            'news.view', 'news.create', 'news.edit',
            'pages.view', 'pages.create', 'pages.edit',
            'partners.view', 'partners.create', 'partners.edit',
            'contacts.view',
        ]);

        $viewerRole->givePermissionTo([
            'portfolios.view',
            'news.view',
            'pages.view',
            'partners.view',
            'contacts.view',
        ]);

        // Create default admin user and assign super admin role
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@osrdigital.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        $adminUser->assignRole('Super Admin');
    }
}
