<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index(): View
    {
        $teams = Team::active()
            ->ordered()
            ->get();

        return view('teams.index', compact('teams'));
    }

    /**
     * Display the specified team member.
     */
    public function show(Team $team): View
    {
        abort_if(!$team->is_active, 404);

        return view('teams.show', compact('team'));
    }
}
