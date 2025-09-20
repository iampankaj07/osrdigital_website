<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class DiagnoseAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose authentication and permission issues for admin panel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Diagnosing admin panel authentication...');

        // Check database connection
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connection: OK');
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return Command::FAILURE;
        }

        // Check if users table exists and has data
        try {
            $userCount = User::count();
            $this->info("✅ Users table: {$userCount} users found");
        } catch (\Exception $e) {
            $this->error('❌ Users table issue: ' . $e->getMessage());
        }

        // Check admin user
        $adminUser = User::where('email', 'admin@osr.com')->first();
        if ($adminUser) {
            $this->info('✅ Admin user exists: ' . $adminUser->email);
            $this->info('   Name: ' . $adminUser->name);
            $this->info('   Created: ' . $adminUser->created_at);
        } else {
            $this->warn('⚠️ Admin user (admin@osr.com) not found');
        }

        // Check roles
        try {
            $roleCount = Role::count();
            $this->info("✅ Roles table: {$roleCount} roles found");

            if ($roleCount > 0) {
                $roles = Role::pluck('name');
                $this->info('   Roles: ' . $roles->implode(', '));
            }
        } catch (\Exception $e) {
            $this->error('❌ Roles table issue: ' . $e->getMessage());
        }

        // Check permissions
        try {
            $permissionCount = Permission::count();
            $this->info("✅ Permissions table: {$permissionCount} permissions found");
        } catch (\Exception $e) {
            $this->error('❌ Permissions table issue: ' . $e->getMessage());
        }

        // Check admin user roles and permissions
        if ($adminUser) {
            $userRoles = $adminUser->getRoleNames();
            if ($userRoles->isNotEmpty()) {
                $this->info('✅ Admin user roles: ' . $userRoles->implode(', '));
            } else {
                $this->warn('⚠️ Admin user has no roles assigned');
            }

            if ($adminUser->hasRole('Super Admin')) {
                $this->info('✅ Admin has Super Admin role');
            } else {
                $this->warn('⚠️ Admin does not have Super Admin role');
            }

            $permissionCount = $adminUser->getAllPermissions()->count();
            $this->info("✅ Admin permissions: {$permissionCount} permissions");
        }

        // Check environment variables
        $this->info('🌍 Environment Configuration:');
        $this->table(['Variable', 'Value'], [
            ['APP_ENV', config('app.env')],
            ['APP_URL', config('app.url')],
            ['DB_CONNECTION', config('database.default')],
            ['CACHE_DRIVER', config('cache.default')],
            ['SESSION_DRIVER', config('session.driver')],
        ]);

        // Check Filament configuration
        $this->info('🎛️ Filament Configuration:');
        $panels = config('filament.panels', []);
        foreach ($panels as $panelId => $panelConfig) {
            $this->info("   Panel '{$panelId}': " . ($panelConfig['path'] ?? 'No path configured'));
        }

        $this->info('');
        $this->info('🔍 Troubleshooting Steps:');
        $this->info('1. If admin user is missing: run `php artisan admin:setup`');
        $this->info('2. If roles/permissions are missing: run `php artisan db:seed --class=RolePermissionSeeder`');
        $this->info('3. Clear cache: `php artisan cache:clear && php artisan config:clear`');
        $this->info('4. Check Laravel Cloud environment variables');

        return Command::SUCCESS;
    }
}
