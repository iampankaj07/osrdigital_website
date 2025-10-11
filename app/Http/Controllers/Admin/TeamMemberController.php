<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $teamMembers = TeamMember::ordered()->get();
        return view('admin.team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Team Member create request:', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'avatar' => 'nullable|string|max:255',
                'linkedin' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'email' => 'nullable|email|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $teamMember = new TeamMember();
            $teamMember->fill($request->all());
            $teamMember->is_active = $request->has('is_active');
            $teamMember->sort_order = $request->input('sort_order', 0);
            $teamMember->save();

            \Log::info('Team Member created successfully', ['id' => $teamMember->id]);

            return redirect()->route('admin.team-members.index')->with('success', 'Team Member created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Team Member:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Team Member: ' . $e->getMessage())->withInput();
        }
    }

    public function show(TeamMember $teamMember)
    {
        return view('admin.team-members.show', compact('teamMember'));
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.team-members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        try {
            \Log::info('Team Member update request:', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'avatar' => 'nullable|string|max:255',
                'linkedin' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'email' => 'nullable|email|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $teamMember->fill($request->all());
            $teamMember->is_active = $request->has('is_active');
            $teamMember->sort_order = $request->input('sort_order', 0);
            $teamMember->save();

            \Log::info('Team Member updated successfully', ['id' => $teamMember->id]);

            return redirect()->route('admin.team-members.index')->with('success', 'Team Member updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Team Member:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Team Member: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(TeamMember $teamMember)
    {
        try {
            $teamMember->delete();
            \Log::info('Team Member deleted successfully', ['id' => $teamMember->id]);
            return redirect()->route('admin.team-members.index')->with('success', 'Team Member deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Team Member:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Team Member: ' . $e->getMessage());
        }
    }

    public function toggleActive(TeamMember $teamMember)
    {
        try {
            $teamMember->is_active = !$teamMember->is_active;
            $teamMember->save();
            
            $status = $teamMember->is_active ? 'activated' : 'deactivated';
            \Log::info("Team Member {$status} successfully", ['id' => $teamMember->id]);
            
            return redirect()->back()->with('success', "Team Member {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Team Member status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Team Member status: ' . $e->getMessage());
        }
    }
}