<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Resources\Content\Schemas\WordPressStyleFormLayout;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return WordPressStyleFormLayout::configure($schema, [
            // Content Configuration
            'title_label' => 'Page Title',
            'title_placeholder' => 'Enter page title here...',
            'slug_prefix' => '/',
            'content_label' => 'Page Content',
            'content_placeholder' => 'Start writing your page content...',
            'show_rich_editor' => true,
            'show_excerpt' => true,
            'excerpt_label' => 'Page Excerpt',
            'excerpt_max_length' => 300,
            'excerpt_rows' => 3,
            'excerpt_placeholder' => 'Optional excerpt for SEO and previews...',
            'excerpt_hint' => 'Brief description for SEO and previews',

            // Layout Configuration
            'show_seo' => true,
            'show_tags' => false,

            // Publishing Configuration
            'status_options' => [
                'draft' => 'Draft',
                'pending' => 'Pending Review',
                'published' => 'Published',
                'private' => 'Private',
            ],
            'status_default' => 'published',
            'show_featured' => false,
            'show_visibility' => true,

            // Media Configuration
            'show_featured_image' => true,
            'featured_image_label' => 'Featured Image',
            'featured_image_hint' => 'Set featured image for this page',
            'featured_image_required' => false,

            // Categories Configuration (using as templates)
            'show_categories' => true,
            'categories_label' => 'Page Template',
            'categories_options' => [
                'default' => 'Default Template',
                'full-width' => 'Full Width',
                'landing' => 'Landing Page',
                'contact' => 'Contact Page',
                'about' => 'About Page',
                'services' => 'Services Page',
                'portfolio' => 'Portfolio Page',
            ],
            'categories_default' => 'default',
            'categories_required' => true,
            'show_secondary_categories' => false,

            // Author Configuration
            'show_author' => false,

            // Discussion Configuration
            'show_discussion' => true,
            'discussion_label' => 'Discussion',
            'allow_comments_default' => false,
            'allow_trackbacks_default' => false,

            // Additional Custom Fields
            'custom_sidebar_sections' => [
                \Filament\Schemas\Components\Section::make('Page Attributes')
                    ->description('Additional page settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        \Filament\Forms\Components\Select::make('parent_id')
                            ->label('Parent Page')
                            ->options([
                                0 => '(no parent)',
                                // Add dynamic page options here
                            ])
                            ->default(0)
                            ->native(false)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('menu_order')
                            ->label('Menu Order')
                            ->numeric()
                            ->default(0)
                            ->hint('Order in navigation menu')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),

                \Filament\Schemas\Components\Section::make('Custom Fields')
                    ->description('Advanced styling options')
                    ->icon('heroicon-o-code-bracket')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('custom_css_class')
                            ->label('CSS Class')
                            ->hint('Additional CSS class for this page')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('custom_css')
                            ->label('Custom CSS')
                            ->rows(5)
                            ->hint('Custom CSS for this page only')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),
            ],
        ]);
    }
}
