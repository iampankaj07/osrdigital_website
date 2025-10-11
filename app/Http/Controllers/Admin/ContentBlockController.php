<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class ContentBlockController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contentBlocks = ContentBlock::ordered()->get();
        $categories = ContentBlock::distinct()->pluck('category')->filter();
        return view('admin.content-blocks.index', compact('contentBlocks', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blockTypes = $this->getAvailableBlockTypes();
        $categories = ContentBlock::distinct()->pluck('category')->filter();
        return view('admin.content-blocks.create', compact('blockTypes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'data' => 'required|array',
            'settings' => 'nullable|array',
            'category' => 'required|string|max:255',
            'is_reusable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        ContentBlock::create($request->all());

        return redirect()->route('admin.content-blocks.index')
            ->with('success', 'Content block created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentBlock $contentBlock)
    {
        return view('admin.content-blocks.show', compact('contentBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentBlock $contentBlock)
    {
        $blockTypes = $this->getAvailableBlockTypes();
        $categories = ContentBlock::distinct()->pluck('category')->filter();
        return view('admin.content-blocks.edit', compact('contentBlock', 'blockTypes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentBlock $contentBlock)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'data' => 'required|array',
            'settings' => 'nullable|array',
            'category' => 'required|string|max:255',
            'is_reusable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $contentBlock->update($request->all());

        return redirect()->route('admin.content-blocks.index')
            ->with('success', 'Content block updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentBlock $contentBlock)
    {
        $contentBlock->delete();

        return redirect()->route('admin.content-blocks.index')
            ->with('success', 'Content block deleted successfully!');
    }

    /**
     * Get available block types
     */
    private function getAvailableBlockTypes()
    {
        return [
            'hero' => 'Hero Section',
            'text' => 'Text Block',
            'image' => 'Image Block',
            'gallery' => 'Image Gallery',
            'cta' => 'Call to Action',
            'features' => 'Features Grid',
            'testimonials' => 'Testimonials',
            'stats' => 'Statistics',
            'contact' => 'Contact Form',
            'newsletter' => 'Newsletter Signup',
            'video' => 'Video Block',
            'accordion' => 'Accordion',
            'tabs' => 'Tabs',
            'cards' => 'Card Grid',
            'banner' => 'Banner',
            'divider' => 'Divider',
        ];
    }

    /**
     * Duplicate a content block
     */
    public function duplicate(ContentBlock $contentBlock)
    {
        $newBlock = $contentBlock->replicate();
        $newBlock->name = $contentBlock->name . ' (Copy)';
        $newBlock->is_reusable = true;
        $newBlock->save();

        return redirect()->route('admin.content-blocks.edit', $newBlock)
            ->with('success', 'Content block duplicated successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(ContentBlock $contentBlock)
    {
        $contentBlock->update(['is_active' => !$contentBlock->is_active]);

        return redirect()->back()
            ->with('success', 'Content block status updated successfully!');
    }
}
