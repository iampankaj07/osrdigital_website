<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password 
                            {--email= : Email of the admin user to reset}
                            {--password= : New password (optional, defaults to admin123456)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset admin user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?: $this->ask('Enter admin email');
        $password = $this->option('password') ?: $this->secret('Enter new password (or press Enter for admin123456)') ?: 'admin123456';

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("✅ Password updated successfully for {$user->name} ({$user->email})");
        $this->info("🔑 New password: {$password}");

        return 0;
    }
}
