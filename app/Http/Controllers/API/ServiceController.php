<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();
        
        if ($services->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'services' => [
                    [
                        'title' => 'Content Acquisition',
                        'description' => 'Strategic identification and acquisition of exceptional movies, music, and short films from creators worldwide.',
                        'icon' => 'fas fa-bullseye'
                    ],
                    [
                        'title' => 'YouTube Publishing',
                        'description' => 'Expert execution of strategic YouTube publishing campaigns to maximize reach and engagement.',
                        'icon' => 'fas fa-play-circle'
                    ],
                    [
                        'title' => 'Global Distribution',
                        'description' => 'Worldwide content distribution across multiple platforms and cultural markets.',
                        'icon' => 'fas fa-globe'
                    ],
                    [
                        'title' => 'Creator Support',
                        'description' => 'Comprehensive support for content creators throughout the entire distribution process.',
                        'icon' => 'fas fa-palette'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'services' => $services->map(function ($service) {
                return [
                    'title' => $service->title,
                    'description' => $service->description,
                    'icon' => $service->icon
                ];
            })
        ]);
    }
}