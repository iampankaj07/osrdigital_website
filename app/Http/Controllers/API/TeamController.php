<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $teams = Team::active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $teams,
            'message' => 'Teams retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string',
            'social_links.*.url' => 'required_with:social_links|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $team = Team::create($validated);

        return response()->json([
            'success' => true,
            'data' => $team,
            'message' => 'Team member created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $team,
            'message' => 'Team member retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'position' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string',
            'social_links.*.url' => 'required_with:social_links|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $team->update($validated);

        return response()->json([
            'success' => true,
            'data' => $team->fresh(),
            'message' => 'Team member updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team): JsonResponse
    {
        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team member deleted successfully'
        ]);
    }
}
