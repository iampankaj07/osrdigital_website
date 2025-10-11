<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSections = HeroSection::orderBy('page')->orderBy('sort_order')->get();
        return view('admin.hero-sections.index', compact('heroSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = HeroSection::getAvailablePages();
        return view('admin.hero-sections.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|in:home,about,partners,team,news|unique:hero_sections,page',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'required|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'button_text_secondary' => 'nullable|string|max:100',
            'button_link_secondary' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $heroSection = HeroSection::create($request->all());

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSection $heroSection)
    {
        return view('admin.hero-sections.show', compact('heroSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSection $heroSection)
    {
        $pages = HeroSection::getAvailablePages();
        return view('admin.hero-sections.edit', compact('heroSection', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSection $heroSection)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|in:home,about,partners,team,news|unique:hero_sections,page,' . $heroSection->id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'required|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'button_text_secondary' => 'nullable|string|max:100',
            'button_link_secondary' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $heroSection->update($request->all());

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSection $heroSection)
    {
        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(HeroSection $heroSection)
    {
        $heroSection->update(['is_active' => !$heroSection->is_active]);
        
        return redirect()->back()
            ->with('success', 'Hero section status updated successfully.');
    }
}