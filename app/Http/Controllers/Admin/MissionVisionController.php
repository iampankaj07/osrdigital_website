<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MissionVision;
use Illuminate\Http\Request;

class MissionVisionController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $missionVision = MissionVision::first();
        
        if (!$missionVision) {
            $missionVision = new MissionVision();
        }
        
        return view('admin.mission-vision.index', compact('missionVision'));
    }

    public function update(Request $request)
    {
        try {
            \Log::info('Mission & Vision update request:', $request->all());
            \Log::info('is_active value:', [
                'has_is_active' => $request->has('is_active'),
                'is_active_value' => $request->input('is_active'),
                'all_inputs' => $request->all()
            ]);
            
            $request->validate([
                'mission_title' => 'required|string|max:255',
                'mission_description' => 'required|string',
                'mission_icon' => 'required|string|max:50',
                'vision_title' => 'required|string|max:255',
                'vision_description' => 'required|string',
                'vision_icon' => 'required|string|max:50',
                'is_active' => 'nullable',
            ]);

            $missionVision = MissionVision::first();
            
            if (!$missionVision) {
                $missionVision = new MissionVision();
                \Log::info('Creating new MissionVision record');
            } else {
                \Log::info('Updating existing MissionVision record', ['id' => $missionVision->id]);
            }

            $missionVision->fill($request->all());
            // Handle checkbox value properly - checkboxes send 'on' when checked, nothing when unchecked
            $missionVision->is_active = $request->has('is_active');
            $missionVision->save();

            \Log::info('Mission & Vision saved successfully', ['id' => $missionVision->id]);

            return redirect()->route('admin.mission-vision.index')->with('success', 'Mission & Vision updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Mission & Vision:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Mission & Vision: ' . $e->getMessage())->withInput();
        }
    }
}