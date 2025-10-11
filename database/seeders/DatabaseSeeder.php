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
        // Run all seeders
        $this->call([
            AdminUserSeeder::class,
            RolePermissionSeeder::class,
            AboutPageSeeder::class,
            PortfolioSeeder::class,
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
