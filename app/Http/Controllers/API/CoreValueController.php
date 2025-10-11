<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoreValue;
use Illuminate\Http\Request;

class CoreValueController extends Controller
{
    public function index()
    {
        $coreValues = CoreValue::active()->ordered()->get();
        
        if ($coreValues->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'values' => [
                    [
                        'title' => 'Innovation',
                        'description' => 'We constantly explore new technologies and platforms to maximize content reach and engagement.',
                        'icon' => 'fas fa-lightbulb'
                    ],
                    [
                        'title' => 'Quality',
                        'description' => 'We maintain the highest standards in content curation and distribution strategies.',
                        'icon' => 'fas fa-star'
                    ],
                    [
                        'title' => 'Partnership',
                        'description' => 'We build lasting relationships with creators, platforms, and audiences worldwide.',
                        'icon' => 'fas fa-handshake'
                    ],
                    [
                        'title' => 'Impact',
                        'description' => 'We measure success by the positive impact our content has on global audiences.',
                        'icon' => 'fas fa-chart-line'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'values' => $coreValues->map(function ($value) {
                return [
                    'title' => $value->title,
                    'description' => $value->description,
                    'icon' => $value->icon
                ];
            })
        ]);
    }
}