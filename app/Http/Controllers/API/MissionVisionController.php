<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MissionVision;
use Illuminate\Http\Request;

class MissionVisionController extends Controller
{
    public function index()
    {
        $missionVision = MissionVision::first();
        
        if (!$missionVision || !$missionVision->is_active) {
            return response()->json([
                'is_active' => false,
                'mission' => [
                    'title' => 'Our Mission',
                    'description' => 'To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide.',
                    'icon' => 'fas fa-bullseye'
                ],
                'vision' => [
                    'title' => 'Our Vision',
                    'description' => 'To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries.',
                    'icon' => 'fas fa-rocket'
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'mission' => [
                'title' => $missionVision->mission_title,
                'description' => $missionVision->mission_description,
                'icon' => $missionVision->mission_icon
            ],
            'vision' => [
                'title' => $missionVision->vision_title,
                'description' => $missionVision->vision_description,
                'icon' => $missionVision->vision_icon
            ]
        ]);
    }
}