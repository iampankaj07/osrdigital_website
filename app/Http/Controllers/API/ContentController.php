<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ContentManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Get all content for the frontend in a single, structured call.
     */
    public function getAllContent()
    {
        return response()->json(ContentManager::getAllContent());
    }

    /**
     * Get a specific page by slug.
     */
    public function getPage(string $slug)
    {
        $page = ContentManager::getPageBySlug($slug);

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        return response()->json($page);
    }

    /**
     * Get a specific setting by key.
     */
    public function getSetting(string $key)
    {
        $content = ContentManager::getSetting($key);

        if (is_null($content)) {
            return response()->json(['error' => 'Setting not found'], 404);
        }

        return response()->json(['key' => $key, 'value' => $content]);
    }

    /**
     * Get all settings (public and private).
     */
    public function getAllSettings()
    {
        return response()->json(ContentManager::getAllSettings());
    }
}