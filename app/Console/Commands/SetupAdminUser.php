<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:setup {--force : Force setup even if admin exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup admin user and permissions for Laravel Cloud deployment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Setting up admin user and permissions...');

        // Check if admin user already exists
        $adminUser = User::where('email', 'admin@osr.com')->first();

        if ($adminUser && !$this->option('force')) {
            $this->info('✅ Admin user already exists: ' . $adminUser->email);

            // Check if user has Super Admin role
            if (!$adminUser->hasRole('Super Admin')) {
                $this->warn('⚠️ Admin user exists but lacks Super Admin role. Assigning...');
                $adminUser->assignRole('Super Admin');
                $this->info('✅ Super Admin role assigned.');
            }

            return Command::SUCCESS;
        }

        // Create permissions if they don't exist
        $this->info('📝 Creating permissions...');
        $permissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete',
            'portfolios.view', 'portfolios.create', 'portfolios.edit', 'portfolios.delete',
            'news.view', 'news.create', 'news.edit', 'news.delete',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'partners.view', 'partners.create', 'partners.edit', 'partners.delete',
            'contacts.view', 'contacts.edit', 'contacts.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Super Admin role
        $this->info('👑 Creating Super Admin role...');
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create or update admin user
        if ($adminUser) {
            $this->info('🔄 Updating existing admin user...');
            $adminUser->update([
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // You should change this
            ]);
        } else {
            $this->info('👤 Creating new admin user...');
            $adminUser = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@osr.com',
                'password' => bcrypt('password'), // You should change this
            ]);
        }

        // Assign Super Admin role
        $adminUser->assignRole('Super Admin');

        $this->info('✅ Admin setup complete!');
        $this->table(['Field', 'Value'], [
            ['Email', $adminUser->email],
            ['Name', $adminUser->name],
            ['Password', 'password (Please change this!)'],
            ['Role', 'Super Admin'],
            ['Permissions', 'All (' . Permission::count() . ' permissions)'],
        ]);

        $this->warn('⚠️ SECURITY: Please change the default password after first login!');

        return Command::SUCCESS;
    }
}
