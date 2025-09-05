<?php

namespace App\Filament\Resources\News\Schemas;

use App\Filament\Resources\Content\Schemas\WordPressStyleFormLayout;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return WordPressStyleFormLayout::configure($schema, [
            // Content Configuration
            'title_label' => 'Article Title',
            'title_placeholder' => 'Enter article title here...',
            'slug_prefix' => '/news/',
            'content_label' => 'Article Content',
            'content_placeholder' => 'Start writing your article...',
            'show_rich_editor' => true,
            'show_excerpt' => true,
            'excerpt_label' => 'Article Excerpt',
            'excerpt_placeholder' => 'Write a brief summary of your article...',
            'excerpt_hint' => 'This will be used for article previews and meta descriptions',

            // Layout Configuration
            'show_seo' => true,
            'show_tags' => true,

            // Publishing Configuration
            'status_options' => [
                'draft' => 'Draft',
                'pending' => 'Pending Review',
                'published' => 'Published',
                'scheduled' => 'Scheduled',
                'private' => 'Private',
            ],
            'status_default' => 'draft',
            'show_featured' => true,
            'show_visibility' => true,

            // Media Configuration
            'show_featured_image' => true,
            'featured_image_label' => 'Featured Image',
            'featured_image_hint' => 'Upload a featured image for this article',
            'featured_image_required' => false,

            // Categories Configuration
            'show_categories' => true,
            'categories_label' => 'Categories',
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
            'categories_default' => 1,
            'categories_required' => true,
            'show_secondary_categories' => true,

            // Author Configuration
            'show_author' => true,
            'author_label' => 'Author',
            'author_default' => 'OSR Digital',
            'author_email_hint' => 'Contact email for this article (optional)',

            // Discussion Configuration
            'show_discussion' => true,
            'discussion_label' => 'Discussion',
            'allow_comments_default' => true,
            'allow_trackbacks_default' => false,
        ]);
    }
}
