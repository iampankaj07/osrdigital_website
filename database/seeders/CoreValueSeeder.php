<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoreValue;

class CoreValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coreValues = [
            [
                'title' => 'Innovation',
                'description' => 'We constantly explore new technologies and platforms to maximize content reach and engagement.',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Quality',
                'description' => 'We maintain the highest standards in content curation and distribution strategies.',
                'icon' => 'fas fa-star',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Partnership',
                'description' => 'We build lasting relationships with creators, platforms, and audiences worldwide.',
                'icon' => 'fas fa-handshake',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Impact',
                'description' => 'We measure success by the positive impact our content has on global audiences.',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($coreValues as $value) {
            CoreValue::create($value);
        }
    }
}