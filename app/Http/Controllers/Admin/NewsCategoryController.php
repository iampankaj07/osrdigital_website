<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = NewsCategory::ordered()->get();
        return view('admin.news-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        NewsCategory::create($request->all());

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsCategory $newsCategory)
    {
        $newsCategory->load('news');
        return view('admin.news-categories.show', compact('newsCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news-categories.edit', compact('newsCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $newsCategory->update($request->all());

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsCategory $newsCategory)
    {
        // Check if category has news articles
        if ($newsCategory->news()->count() > 0) {
            return redirect()->route('admin.news-categories.index')
                ->with('error', 'Cannot delete category with existing news articles. Please reassign or delete the articles first.');
        }

        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
