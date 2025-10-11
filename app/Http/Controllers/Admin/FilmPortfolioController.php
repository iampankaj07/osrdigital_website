<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmPortfolioController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = FilmPortfolio::with('category')->ordered()->get();
        return view('admin.film-portfolios.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = FilmCategory::active()->ordered()->get();
        return view('admin.film-portfolios.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'featured_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:2048',
            'featured_image_url' => 'nullable|string|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'duration' => 'nullable|string|max:50',
            'category_id' => 'required|exists:film_categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_published'] = $request->has('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('film-portfolios', 'public');
        } elseif ($request->filled('featured_image_url')) {
            // Handle FilePond uploaded image URL
            $imageUrl = $request->input('featured_image_url');
            // Extract the filename from the URL (remove /storage/ prefix)
            $filename = str_replace('/storage/', '', $imageUrl);
            $data['featured_image'] = $filename;
        }

        FilmPortfolio::create($data);

        return redirect()->route('admin.film-portfolios.index')
            ->with('success', 'Film portfolio created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FilmPortfolio $filmPortfolio)
    {
        $filmPortfolio->load('category');
        return view('admin.film-portfolios.show', compact('filmPortfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FilmPortfolio $filmPortfolio)
    {
        $categories = FilmCategory::active()->ordered()->get();
        return view('admin.film-portfolios.edit', compact('filmPortfolio', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FilmPortfolio $filmPortfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'featured_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:2048',
            'featured_image_url' => 'nullable|string|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'duration' => 'nullable|string|max:50',
            'category_id' => 'required|exists:film_categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_published'] = $request->has('is_published');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($filmPortfolio->featured_image) {
                \Storage::disk('public')->delete($filmPortfolio->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('film-portfolios', 'public');
        } elseif ($request->filled('featured_image_url')) {
            // Handle FilePond uploaded image URL
            $imageUrl = $request->input('featured_image_url');
            // Extract the filename from the URL (remove /storage/ prefix)
            $filename = str_replace('/storage/', '', $imageUrl);
            $data['featured_image'] = $filename;
        }

        $filmPortfolio->update($data);

        return redirect()->route('admin.film-portfolios.index')
            ->with('success', 'Film portfolio updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FilmPortfolio $filmPortfolio)
    {
        // Delete featured image if exists
        if ($filmPortfolio->featured_image) {
            \Storage::disk('public')->delete($filmPortfolio->featured_image);
        }

        $filmPortfolio->delete();

        return redirect()->route('admin.film-portfolios.index')
            ->with('success', 'Film portfolio deleted successfully!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(FilmPortfolio $filmPortfolio)
    {
        $filmPortfolio->update(['is_featured' => !$filmPortfolio->is_featured]);

        $status = $filmPortfolio->is_featured ? 'featured' : 'unfeatured';
        return redirect()->route('admin.film-portfolios.index')
            ->with('success', "Film portfolio {$status} successfully!");
    }

    /**
     * Toggle published status
     */
    public function togglePublished(FilmPortfolio $filmPortfolio)
    {
        $filmPortfolio->update(['is_published' => !$filmPortfolio->is_published]);

        $status = $filmPortfolio->is_published ? 'published' : 'unpublished';
        return redirect()->route('admin.film-portfolios.index')
            ->with('success', "Film portfolio {$status} successfully!");
    }

    public function upload(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:png,svg,jpg,jpeg|max:5120',
        ]);

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('film-portfolios', $filename, 'public');
            
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }
}
