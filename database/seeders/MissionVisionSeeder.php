<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MissionVision;

class MissionVisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MissionVision::create([
            'mission_title' => 'Our Mission',
            'mission_description' => 'To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide.',
            'mission_icon' => 'fas fa-bullseye',
            'vision_title' => 'Our Vision',
            'vision_description' => 'To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries.',
            'vision_icon' => 'fas fa-rocket',
            'is_active' => true,
        ]);
    }
}