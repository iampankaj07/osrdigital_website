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
            RolePermissionSeeder::class,
            PageSeeder::class,
            PortfolioSeeder::class,
            PartnerSeeder::class,
            NewsSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
