<?php

namespace App\Filament\Resources\News\Schemas;

use App\Filament\Resources\Content\Schemas\ContentFormLayout;
use Filament\Schemas\Schema;

/**
 * Example: Using the standardized ContentFormLayout for News
 */
class NewsFormExample
{
    public static function configure(Schema $schema): Schema
    {
        return ContentFormLayout::configure($schema, [
            'title_label' => 'Article Title',
            'slug_prefix' => '/news/',
            'content_label' => 'Article Content',
            'excerpt_label' => 'Article Excerpt',
            'excerpt_placeholder' => 'Write a brief summary of your article...',
            'excerpt_hint' => 'This will be used for article previews and meta descriptions',
            'categories_options' => [
                1 => 'Uncategorized',
                2 => 'Technology News',
                3 => 'Business News',
                4 => 'Entertainment',
                5 => 'Sports',
                6 => 'Health & Wellness',
                7 => 'Politics',
                8 => 'Science & Innovation',
                9 => 'Local News',
                10 => 'Breaking News',
            ],
            'featured_image_hint' => 'Upload a featured image for this article',
        ]);
    }
}
