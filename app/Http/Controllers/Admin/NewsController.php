<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = NewsCategory::active()->ordered()->get();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:5120',
            'featured_image_path' => 'nullable|string', // For FilePond
            'author_name' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'required|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Handle featured image upload (FilePond or direct upload)
        if ($request->has('featured_image_path')) {
            $data['featured_image'] = $request->featured_image_path;
        } elseif ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = NewsCategory::active()->ordered()->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:5120',
            'featured_image_path' => 'nullable|string', // For FilePond
            'author_name' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'required|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Handle featured image upload (FilePond or direct upload)
        if ($request->has('featured_image_path')) {
            // Delete old image if exists
            if ($news->featured_image && $news->featured_image !== $request->featured_image_path) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $request->featured_image_path;
        } elseif ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(News $news)
    {
        $news->update(['featured' => !$news->featured]);

        $status = $news->featured ? 'featured' : 'unfeatured';
        return redirect()->route('admin.news.index')
            ->with('success', "News article {$status} successfully!");
    }
}
