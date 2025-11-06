<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::published()->ordered();

        // Filter by featured status
        if ($request->has('featured') && $request->boolean('featured')) {
            $query->featured();
        }

        // Limit results
        $limit = $request->get('limit', 10);
        $testimonials = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function featured(Request $request)
    {
        $limit = $request->get('limit', 4);
        $testimonials = Testimonial::getFeaturedTestimonials($limit);

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function show(Testimonial $testimonial)
    {
        if (!$testimonial->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Testimonial not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $testimonial
        ]);
    }
}
