<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $testimonials = Testimonial::ordered()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'project' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_url' => 'nullable|string|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'name', 'role', 'company', 'content', 'project', 
            'is_featured', 'is_published', 'sort_order'
        ]);

        // Handle avatar upload - prioritize FilePond URL if available
        if ($request->filled('avatar_url')) {
            $data['avatar_url'] = $request->avatar_url;
        } elseif ($request->hasFile('avatar')) {
            $data['avatar_url'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'project' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_url' => 'nullable|string|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'name', 'role', 'company', 'content', 'project', 
            'is_featured', 'is_published', 'sort_order'
        ]);

        // Handle avatar upload - prioritize FilePond URL if available
        if ($request->filled('avatar_url')) {
            $data['avatar_url'] = $request->avatar_url;
        } elseif ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($testimonial->avatar_url && Storage::disk('public')->exists($testimonial->avatar_url)) {
                Storage::disk('public')->delete($testimonial->avatar_url);
            }
            $data['avatar_url'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Delete avatar if exists
        if ($testimonial->avatar_url && Storage::disk('public')->exists($testimonial->avatar_url)) {
            Storage::disk('public')->delete($testimonial->avatar_url);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }

    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        
        $status = $testimonial->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()
            ->with('success', "Testimonial {$status} successfully!");
    }

    public function togglePublished(Testimonial $testimonial)
    {
        $testimonial->update(['is_published' => !$testimonial->is_published]);
        
        $status = $testimonial->is_published ? 'published' : 'unpublished';
        return redirect()->back()
            ->with('success', "Testimonial {$status} successfully!");
    }

    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('testimonials', $filename, 'public');
            
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
