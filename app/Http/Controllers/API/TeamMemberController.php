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
                'teamMembers' => []
            ]);
        }

        return response()->json([
            'is_active' => true,
            'teamMembers' => $teamMembers->map(function ($member) {
                return [
                    'name' => $member->name,
                    'slug' => $member->slug,
                    'position' => $member->position,
                    'department' => $member->department,
                    'description' => $member->description,
                    'avatar' => $member->image_url,
                    'image' => $member->image_url,
                    'linkedin' => $member->linkedin,
                    'twitter' => $member->twitter,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'social_links' => $member->social_links
                ];
            })
        ]);
    }

    public function show($slug)
    {
        $member = TeamMember::where('slug', $slug)->active()->first();

        if (!$member) {
            return response()->json(['error' => 'Team member not found'], 404);
        }

        return response()->json([
            'name' => $member->name,
            'slug' => $member->slug,
            'position' => $member->position,
            'department' => $member->department,
            'description' => $member->description,
            'avatar' => $member->image_url,
            'image' => $member->image_url,
            'linkedin' => $member->linkedin,
            'twitter' => $member->twitter,
            'email' => $member->email,
            'phone' => $member->phone,
            'social_links' => $member->social_links
        ]);
    }
}
