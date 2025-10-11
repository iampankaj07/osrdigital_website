<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnershipBenefit;
use Illuminate\Http\Request;

class PartnershipBenefitController extends Controller
{
    public function index()
    {
        $benefits = PartnershipBenefit::active()->ordered()->get();
        
        if ($benefits->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'benefits' => [
                    [
                        'title' => 'Global Reach',
                        'description' => 'Access to worldwide audiences through our extensive distribution network.',
                        'icon' => 'fas fa-globe'
                    ],
                    [
                        'title' => 'Revenue Sharing',
                        'description' => 'Fair and transparent revenue sharing models for all partners.',
                        'icon' => 'fas fa-chart-line'
                    ],
                    [
                        'title' => 'Marketing Support',
                        'description' => 'Comprehensive marketing and promotional support for your content.',
                        'icon' => 'fas fa-bullhorn'
                    ],
                    [
                        'title' => 'Analytics & Insights',
                        'description' => 'Detailed analytics and insights to optimize your content performance.',
                        'icon' => 'fas fa-chart-bar'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'benefits' => $benefits->map(function ($benefit) {
                return [
                    'title' => $benefit->title,
                    'description' => $benefit->description,
                    'icon' => $benefit->icon
                ];
            })
        ]);
    }
}