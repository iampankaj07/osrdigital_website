<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\ContentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DynamicPageController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = DynamicPage::ordered()->get();
        return view('admin.dynamic-pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contentBlocks = ContentBlock::active()->reusable()->ordered()->get();
        $templates = $this->getAvailableTemplates();
        return view('admin.dynamic-pages.create', compact('contentBlocks', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:dynamic_pages,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'required|string',
            'content_blocks' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_published' => 'boolean',
            'is_homepage' => 'boolean',
        ]);

        // If this is set as homepage, unset other homepages
        if ($request->is_homepage) {
            DynamicPage::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        $page = DynamicPage::create($request->all());

        return redirect()->route('admin.dynamic-pages.index')
            ->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DynamicPage $dynamicPage)
    {
        return view('admin.dynamic-pages.show', compact('dynamicPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DynamicPage $dynamicPage)
    {
        $contentBlocks = ContentBlock::active()->reusable()->ordered()->get();
        $templates = $this->getAvailableTemplates();
        return view('admin.dynamic-pages.edit', compact('dynamicPage', 'contentBlocks', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DynamicPage $dynamicPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:dynamic_pages,slug,' . $dynamicPage->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'required|string',
            'content_blocks' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_published' => 'boolean',
            'is_homepage' => 'boolean',
        ]);

        // If this is set as homepage, unset other homepages
        if ($request->is_homepage) {
            DynamicPage::where('is_homepage', true)
                ->where('id', '!=', $dynamicPage->id)
                ->update(['is_homepage' => false]);
        }

        $dynamicPage->update($request->all());

        return redirect()->route('admin.dynamic-pages.index')
            ->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DynamicPage $dynamicPage)
    {
        $dynamicPage->delete();

        return redirect()->route('admin.dynamic-pages.index')
            ->with('success', 'Page deleted successfully!');
    }

    /**
     * Get available page templates
     */
    private function getAvailableTemplates()
    {
        return [
            'default' => 'Default Template',
            'landing' => 'Landing Page',
            'about' => 'About Page',
            'contact' => 'Contact Page',
            'portfolio' => 'Portfolio Page',
            'blog' => 'Blog Page',
        ];
    }

    /**
     * Preview a page
     */
    public function preview(DynamicPage $dynamicPage)
    {
        return view('admin.dynamic-pages.preview', compact('dynamicPage'));
    }

    /**
     * Duplicate a page
     */
    public function duplicate(DynamicPage $dynamicPage)
    {
        $newPage = $dynamicPage->replicate();
        $newPage->title = $dynamicPage->title . ' (Copy)';
        $newPage->slug = $dynamicPage->slug . '-copy-' . time();
        $newPage->is_published = false;
        $newPage->is_homepage = false;
        $newPage->save();

        return redirect()->route('admin.dynamic-pages.edit', $newPage)
            ->with('success', 'Page duplicated successfully!');
    }
}
