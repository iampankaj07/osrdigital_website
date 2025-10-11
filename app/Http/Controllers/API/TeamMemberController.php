<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::active()->ordered()->get();
        
        if ($teamMembers->isEmpty()) {
            return response()->json([
                'is_active' => false,
                'teamMembers' => [
                    [
                        'name' => 'Sarah Chen',
                        'position' => 'CEO & Founder',
                        'department' => 'Leadership',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=SC',
                        'linkedin' => 'https://linkedin.com/in/sarahchen',
                        'twitter' => 'https://twitter.com/sarahchen',
                        'email' => 'sarah@osrdigital.com'
                    ],
                    [
                        'name' => 'Michael Rodriguez',
                        'position' => 'CTO',
                        'department' => 'Technology',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=MR',
                        'linkedin' => 'https://linkedin.com/in/michaelrodriguez',
                        'twitter' => 'https://twitter.com/michaelrod',
                        'email' => 'michael@osrdigital.com'
                    ],
                    [
                        'name' => 'Emma Thompson',
                        'position' => 'Head of Content Strategy',
                        'department' => 'Content',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=ET',
                        'linkedin' => 'https://linkedin.com/in/emmathompson',
                        'twitter' => 'https://twitter.com/emmathompson',
                        'email' => 'emma@osrdigital.com'
                    ],
                    [
                        'name' => 'David Park',
                        'position' => 'Head of Partnerships',
                        'department' => 'Business Development',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=DP',
                        'linkedin' => 'https://linkedin.com/in/davidpark',
                        'twitter' => 'https://twitter.com/davidpark',
                        'email' => 'david@osrdigital.com'
                    ],
                    [
                        'name' => 'Lisa Wang',
                        'position' => 'Head of Marketing',
                        'department' => 'Marketing',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=LW',
                        'linkedin' => 'https://linkedin.com/in/lisawang',
                        'twitter' => 'https://twitter.com/lisawang',
                        'email' => 'lisa@osrdigital.com'
                    ],
                    [
                        'name' => 'James Wilson',
                        'position' => 'Head of Operations',
                        'department' => 'Operations',
                        'avatar' => 'https://via.placeholder.com/300x300/EC681D/FFFFFF?text=JW',
                        'linkedin' => 'https://linkedin.com/in/jameswilson',
                        'twitter' => 'https://twitter.com/jameswilson',
                        'email' => 'james@osrdigital.com'
                    ]
                ]
            ]);
        }

        return response()->json([
            'is_active' => true,
            'teamMembers' => $teamMembers->map(function ($member) {
                return [
                    'name' => $member->name,
                    'position' => $member->position,
                    'department' => $member->department,
                    'avatar' => $member->avatar,
                    'linkedin' => $member->linkedin,
                    'twitter' => $member->twitter,
                    'email' => $member->email
                ];
            })
        ]);
    }
}