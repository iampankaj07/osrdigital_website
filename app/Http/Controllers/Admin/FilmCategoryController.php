<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FilmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmCategoryController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = FilmCategory::ordered()->get();
        return view('admin.film-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.film-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        FilmCategory::create($data);

        return redirect()->route('admin.film-categories.index')
            ->with('success', 'Film category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FilmCategory $filmCategory)
    {
        return view('admin.film-categories.show', compact('filmCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FilmCategory $filmCategory)
    {
        return view('admin.film-categories.edit', compact('filmCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FilmCategory $filmCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $filmCategory->update($data);

        return redirect()->route('admin.film-categories.index')
            ->with('success', 'Film category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FilmCategory $filmCategory)
    {
        // Check if category has films
        if ($filmCategory->filmPortfolios()->count() > 0) {
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Cannot delete category that has films. Please move or delete the films first.');
        }

        $filmCategory->delete();

        return redirect()->route('admin.film-categories.index')
            ->with('success', 'Film category deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(FilmCategory $filmCategory)
    {
        $filmCategory->update(['is_active' => !$filmCategory->is_active]);

        $status = $filmCategory->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.film-categories.index')
            ->with('success', "Film category {$status} successfully!");
    }
}
