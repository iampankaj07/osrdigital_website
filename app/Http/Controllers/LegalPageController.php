<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalPage;

class LegalPageController extends Controller
{
    public function privacyPolicy()
    {
        $page = LegalPage::where('page_type', 'privacy_policy')
                        ->where('is_published', true)
                        ->first();

        if (!$page) {
            abort(404, 'Privacy Policy not found');
        }

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json([
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => $page->content,
                    'excerpt' => $page->excerpt,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'last_updated_at' => $page->last_updated_at?->format('F j, Y'),
                ]
            ]);
        }

        // Return HTML view for browser requests
        return view('legal.show', [
            'page' => $page,
            'type' => 'privacy-policy'
        ]);
    }

    public function termsOfService()
    {
        $page = LegalPage::where('page_type', 'terms_of_service')
                        ->where('is_published', true)
                        ->first();

        if (!$page) {
            abort(404, 'Terms of Service not found');
        }

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json([
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => $page->content,
                    'excerpt' => $page->excerpt,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'last_updated_at' => $page->last_updated_at?->format('F j, Y'),
                ]
            ]);
        }

        // Return HTML view for browser requests
        return view('legal.show', [
            'page' => $page,
            'type' => 'terms-of-service'
        ]);
    }

    public function cookiesPolicy()
    {
        $page = LegalPage::where('page_type', 'cookies_policy')
                        ->where('is_published', true)
                        ->first();

        if (!$page) {
            abort(404, 'Cookies Policy not found');
        }

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json([
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'content' => $page->content,
                    'excerpt' => $page->excerpt,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'last_updated_at' => $page->last_updated_at?->format('F j, Y'),
                ]
            ]);
        }

        // Return HTML view for browser requests
        return view('legal.show', [
            'page' => $page,
            'type' => 'cookies-policy'
        ]);
    }

    public function show($slug)
    {
        $page = LegalPage::where('slug', $slug)
                        ->where('is_published', true)
                        ->first();

        if (!$page) {
            abort(404, 'Legal page not found');
        }

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json([
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'page_type' => $page->page_type,
                    'content' => $page->content,
                    'excerpt' => $page->excerpt,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'last_updated_at' => $page->last_updated_at?->format('F j, Y'),
                ]
            ]);
        }

        // Return HTML view for browser requests
        return view('legal.show', [
            'page' => $page,
            'type' => $slug
        ]);
    }
}
