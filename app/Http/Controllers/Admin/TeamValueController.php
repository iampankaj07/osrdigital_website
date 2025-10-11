<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamValue;
use Illuminate\Http\Request;

class TeamValueController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $teamValues = TeamValue::ordered()->get();
        return view('admin.team-values.index', compact('teamValues'));
    }

    public function create()
    {
        return view('admin.team-values.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Team Value create request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $teamValue = new TeamValue();
            $teamValue->fill($request->all());
            $teamValue->is_active = $request->has('is_active');
            $teamValue->sort_order = $request->input('sort_order', 0);
            $teamValue->save();

            \Log::info('Team Value created successfully', ['id' => $teamValue->id]);

            return redirect()->route('admin.team-values.index')->with('success', 'Team Value created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Team Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Team Value: ' . $e->getMessage())->withInput();
        }
    }

    public function show(TeamValue $teamValue)
    {
        return view('admin.team-values.show', compact('teamValue'));
    }

    public function edit(TeamValue $teamValue)
    {
        return view('admin.team-values.edit', compact('teamValue'));
    }

    public function update(Request $request, TeamValue $teamValue)
    {
        try {
            \Log::info('Team Value update request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $teamValue->fill($request->all());
            $teamValue->is_active = $request->has('is_active');
            $teamValue->sort_order = $request->input('sort_order', 0);
            $teamValue->save();

            \Log::info('Team Value updated successfully', ['id' => $teamValue->id]);

            return redirect()->route('admin.team-values.index')->with('success', 'Team Value updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Team Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Team Value: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(TeamValue $teamValue)
    {
        try {
            $teamValue->delete();
            \Log::info('Team Value deleted successfully', ['id' => $teamValue->id]);
            return redirect()->route('admin.team-values.index')->with('success', 'Team Value deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Team Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Team Value: ' . $e->getMessage());
        }
    }

    public function toggleActive(TeamValue $teamValue)
    {
        try {
            $teamValue->is_active = !$teamValue->is_active;
            $teamValue->save();
            
            $status = $teamValue->is_active ? 'activated' : 'deactivated';
            \Log::info("Team Value {$status} successfully", ['id' => $teamValue->id]);
            
            return redirect()->back()->with('success', "Team Value {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Team Value status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Team Value status: ' . $e->getMessage());
        }
    }
}