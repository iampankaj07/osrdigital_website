<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrustedPartner;
use Illuminate\Http\Request;

class TrustedPartnerController extends Controller
{
    public function index()
    {
        $partners = TrustedPartner::active()->ordered()->get();
        
        if ($partners->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'partners' => [
                    [
                        'name' => 'YouTube',
                        'description' => 'Global video sharing platform',
                        'logo' => null,
                        'website_url' => 'https://youtube.com'
                    ],
                    [
                        'name' => 'Vimeo',
                        'description' => 'Professional video platform',
                        'logo' => null,
                        'website_url' => 'https://vimeo.com'
                    ],
                    [
                        'name' => 'Netflix',
                        'description' => 'Streaming entertainment service',
                        'logo' => null,
                        'website_url' => 'https://netflix.com'
                    ],
                    [
                        'name' => 'Amazon Prime',
                        'description' => 'Video streaming service',
                        'logo' => null,
                        'website_url' => 'https://primevideo.com'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'partners' => $partners->map(function ($partner) {
                return [
                    'name' => $partner->name,
                    'description' => $partner->description,
                    'logo' => $partner->logo,
                    'website_url' => $partner->website_url
                ];
            })
        ]);
    }
}