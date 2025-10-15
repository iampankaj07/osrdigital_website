<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'osr:install {--fresh : Clear all existing data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install OSR Digital with all necessary data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting OSR Digital Installation...');
        $this->newLine();

        // Check if --fresh flag is provided
        $fresh = $this->option('fresh');
        
        if ($fresh) {
            $this->warn('⚠️  This will clear all existing data!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('Installation cancelled.');
                return;
            }
            
            $this->info('🧹 Clearing existing data...');
            $this->clearDatabase();
        }

        // Run migrations
        $this->info('📦 Running database migrations...');
        Artisan::call('migrate', ['--force' => true]);
        $this->info('✅ Migrations completed');

        // Run the installation seeder
        $this->info('🌱 Seeding database with sample data...');
        Artisan::call('db:seed', ['--class' => 'InstallationSeeder', '--force' => true]);
        $this->info('✅ Database seeded successfully');

        // Clear caches
        $this->info('🧹 Clearing application caches...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('✅ Caches cleared');

        // Build frontend assets
        $this->info('🎨 Building frontend assets...');
        $this->call('npm', ['run', 'build']);
        $this->info('✅ Frontend assets built');

        $this->newLine();
        $this->info('🎉 OSR Digital installation completed successfully!');
        $this->newLine();
        
        $this->table(['Item', 'Details'], [
            ['Admin Login', 'admin@osrdigital.com'],
            ['Admin Password', 'password'],
            ['Admin Panel', '/admin'],
            ['Frontend', '/'],
            ['API Documentation', '/api/documentation'],
        ]);

        $this->newLine();
        $this->info('📚 Next Steps:');
        $this->line('1. Update your .env file with your database credentials');
        $this->line('2. Configure your mail settings for contact forms');
        $this->line('3. Upload your logo and branding assets');
        $this->line('4. Customize the content to match your brand');
        $this->line('5. Set up SSL certificate for production');
        
        $this->newLine();
        $this->info('🔗 Useful Commands:');
        $this->line('• php artisan serve - Start development server');
        $this->line('• php artisan queue:work - Start queue worker');
        $this->line('• php artisan schedule:work - Start scheduler');
        $this->line('• npm run dev - Start frontend development');
        
        $this->newLine();
        $this->info('📖 Documentation: https://codebundles.com/docs/osr-digital');
        $this->info('💬 Support: https://codebundles.com/support');
    }

    private function clearDatabase()
    {
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Get all table names
            $tables = DB::select('SHOW TABLES');
            $databaseName = DB::getDatabaseName();
            $tableKey = 'Tables_in_' . $databaseName;
            
            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                if ($tableName !== 'migrations') {
                    DB::table($tableName)->truncate();
                    $this->line("   Cleared table: {$tableName}");
                }
            }
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->info('✅ Database cleared successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error clearing database: ' . $e->getMessage());
            throw $e;
        }
    }
}
