<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminSettings;

class GlobalImpactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set Global Impact title
        AdminSettings::set(
            'global_impact_title',
            'Our Global Impact',
            'string',
            'global_impact',
            'Global Impact section title',
            true
        );

        // Set Global Impact subtitle
        AdminSettings::set(
            'global_impact_subtitle',
            'Numbers that speak to our commitment to bringing quality content to global audiences',
            'string',
            'global_impact',
            'Global Impact section subtitle',
            true
        );

        // Set Global Impact statistics
        $stats = [
            ['number' => '500+', 'label' => 'Movies Published', 'icon' => '🎬'],
            ['number' => '2,000+', 'label' => 'Songs Released', 'icon' => '🎵'],
            ['number' => '800+', 'label' => 'Short Films', 'icon' => '🎥'],
            ['number' => '50M+', 'label' => 'Total Views', 'icon' => '👁️']
        ];

        AdminSettings::set(
            'global_impact_stats',
            $stats,
            'json',
            'global_impact',
            'Global Impact statistics',
            true
        );
    }
}
