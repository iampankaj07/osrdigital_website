<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Associate;

class AssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $associates = [
            [
                'name' => 'OSR Digital',
                'logo' => '/images/logo.png',
                'website' => 'https://osrdigital.com/',
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'OSR Connect',
                'logo' => '/images/associates/osr-connect.png',
                'website' => 'https://osrdigital.com/',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'OSR Reality',
                'logo' => '/images/associates/osr-reality.png',
                'website' => 'https://osrdigital.com/',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'OSR Sports',
                'logo' => '/images/associates/osr-sports.png',
                'website' => 'https://osrdigital.com/',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($associates as $associate) {
            Associate::firstOrCreate(
                ['name' => $associate['name']],
                $associate
            );
        }
    }
}
