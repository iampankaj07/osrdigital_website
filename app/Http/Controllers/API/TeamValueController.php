<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamValue;
use Illuminate\Http\Request;

class TeamValueController extends Controller
{
    public function index()
    {
        $teamValues = TeamValue::active()->ordered()->get();
        
        if ($teamValues->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'values' => [
                    [
                        'title' => 'Innovation',
                        'description' => 'We constantly push boundaries and explore new technologies to stay ahead in the rapidly evolving digital landscape.',
                        'icon' => 'fas fa-lightbulb'
                    ],
                    [
                        'title' => 'Collaboration',
                        'description' => 'We believe in the power of teamwork and foster an environment where every voice is heard and valued.',
                        'icon' => 'fas fa-handshake'
                    ],
                    [
                        'title' => 'Excellence',
                        'description' => 'We strive for the highest standards in everything we do, from content curation to client service.',
                        'icon' => 'fas fa-chart-line'
                    ],
                    [
                        'title' => 'Global Impact',
                        'description' => 'We\'re committed to making content accessible worldwide and celebrating diverse voices and cultures.',
                        'icon' => 'fas fa-globe'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'values' => $teamValues->map(function ($value) {
                return [
                    'title' => $value->title,
                    'description' => $value->description,
                    'icon' => $value->icon
                ];
            })
        ]);
    }
}