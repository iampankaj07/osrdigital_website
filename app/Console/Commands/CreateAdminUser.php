<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-user 
                            {--name= : Name of the admin user}
                            {--email= : Email of the admin user}
                            {--password= : Password for the admin user}
                            {--role=superadmin : Role to assign (superadmin, admin, editor, viewer)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user with specified role and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔐 Creating Admin User...');
        $this->newLine();

        // Get user input
        $name = $this->option('name') ?: $this->ask('Enter admin name');
        $email = $this->option('email') ?: $this->ask('Enter admin email');
        $password = $this->option('password') ?: $this->secret('Enter admin password');
        $roleName = $this->option('role');

        // Validate input
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  - {$error}");
            }
            return 1;
        }

        // Validate role
        $validRoles = ['superadmin', 'admin', 'editor', 'viewer'];
        if (!in_array($roleName, $validRoles)) {
            $this->error("Invalid role. Must be one of: " . implode(', ', $validRoles));
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        // Map role names to actual role names in database
        $roleMapping = [
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'editor' => 'Editor',
            'viewer' => 'Viewer'
        ];
        
        $actualRoleName = $roleMapping[$roleName] ?? $roleName;
        
        // Assign role
        $role = Role::where('name', $actualRoleName)->first();
        if (!$role) {
            $this->error("Role '{$actualRoleName}' not found. Please run the RolePermissionSeeder first.");
            return 1;
        }

        $user->assignRole($role);

        $this->info('✅ Admin user created successfully!');
        $this->newLine();
        $this->info("👤 Name: {$user->name}");
        $this->info("📧 Email: {$user->email}");
        $this->info("🔑 Password: [hidden]");
        $this->info("🎭 Role: {$role->name}");
        $this->newLine();
        $this->info('You can now login with these credentials.');

        return 0;
    }
}
