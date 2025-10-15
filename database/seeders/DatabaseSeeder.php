<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // For fresh installation, use the comprehensive InstallationSeeder
        if (app()->environment('local') || $this->command->confirm('This will clear all existing data. Continue?')) {
            $this->call([
                InstallationSeeder::class,
            ]);
        } else {
            // For production or when user declines, run individual seeders
            $this->call([
                AdminUserSeeder::class,
                DistributionServiceSeeder::class,
                FilmCategorySeeder::class,
                FilmPortfolioSeeder::class,
                RolePermissionSeeder::class,
                AboutPageSeeder::class,
                PortfolioSeeder::class,
                NewsCategorySeeder::class, // Must run before NewsSeeder
                NewsSeeder::class,
                TeamSeeder::class,
                DynamicPageSeeder::class,
                MissionVisionSeeder::class,
                CoreValueSeeder::class,
                ServiceSeeder::class,
                TrustedPartnerSeeder::class,
                PartnershipBenefitSeeder::class,
                TeamMemberSeeder::class,
                TeamValueSeeder::class,
            ]);
        }
    }
}
