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
            'status_field' => 'is_published',
            'status_options' => [
                false => 'Draft',
                true => 'Published',
            ],
            'status_default' => true,
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
            'categories_field' => 'template_type',
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
            'show_discussion' => false,
            'discussion_label' => 'Discussion',
            'allow_comments_default' => false,
            'allow_trackbacks_default' => false,

            // Additional Custom Fields
            'custom_content_sections' => [
                // Hidden field to maintain template type for About page
                \Filament\Forms\Components\Hidden::make('template_type')
                    ->default('about'),
                \Filament\Schemas\Components\Section::make('Mission Section')
                    ->description('Company mission statement and content')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('about_mission_title')
                            ->label('Mission Section Title')
                            ->default('Our Mission')
                            ->hint('Title for the mission section')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('about_mission')
                            ->label('Mission Statement')
                            ->rows(4)
                            ->hint('Describe your company mission and purpose')
                            ->placeholder('Enter your company mission statement...')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('template_type') === 'about')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'wp-content-section',
                        'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                    ]),

                \Filament\Schemas\Components\Section::make('Vision Section')
                    ->description('Company vision statement and future goals')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('about_vision_title')
                            ->label('Vision Section Title')
                            ->default('Our Vision')
                            ->hint('Title for the vision section')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('about_vision')
                            ->label('Vision Statement')
                            ->rows(4)
                            ->hint('Describe your company vision and future aspirations')
                            ->placeholder('Enter your company vision statement...')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('template_type') === 'about')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'wp-content-section',
                        'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                    ]),

                \Filament\Schemas\Components\Section::make('What We Do Section')
                    ->description('Services and main business activities')
                    ->icon('heroicon-o-squares-plus')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('about_what_we_do_title')
                            ->label('What We Do Section Title')
                            ->default('What We Do')
                            ->hint('Title for the services section')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Textarea::make('about_what_we_do_description')
                            ->label('What We Do Description')
                            ->rows(3)
                            ->hint('Brief description for the services section')
                            ->placeholder('We provide comprehensive digital content solutions...')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\Repeater::make('about_services')
                            ->label('Services')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('title')
                                    ->label('Service Title')
                                    ->required()
                                    ->columnSpanFull(),

                                \Filament\Forms\Components\Textarea::make('description')
                                    ->label('Service Description')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(3)
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Service')
                            ->addActionLabel('Add Service')
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('template_type') === 'about')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'wp-content-section',
                        'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                    ]),

                \Filament\Schemas\Components\Section::make('Hero Section Settings')
                    ->description('Hero section buttons and content')
                    ->icon('heroicon-o-sparkles')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('about_hero_badge_text')
                            ->label('Hero Badge Text')
                            ->hint('Text for the hero section badge')
                            ->placeholder('Trusted by creators worldwide')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_primary_button_text')
                            ->label('Primary Button Text')
                            ->hint('Text for the primary CTA button')
                            ->placeholder('Our Story')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_secondary_button_text')
                            ->label('Secondary Button Text')
                            ->hint('Text for the secondary button')
                            ->placeholder('Watch Video')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_youtube_link')
                            ->label('YouTube Video Link')
                            ->url()
                            ->hint('YouTube video URL for the story section')
                            ->placeholder('https://youtube.com/watch?v=...')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('template_type') === 'about')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'wp-content-section',
                        'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                    ]),

                \Filament\Schemas\Components\Section::make('Statistics Section')
                    ->description('Company metrics and achievements')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('about_stat_1_value')
                            ->label('Statistic 1 Value')
                            ->hint('e.g., 25+')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_1_label')
                            ->label('Statistic 1 Label')
                            ->hint('e.g., Years Experience')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_2_value')
                            ->label('Statistic 2 Value')
                            ->hint('e.g., 500+')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_2_label')
                            ->label('Statistic 2 Label')
                            ->hint('e.g., Projects Completed')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_3_value')
                            ->label('Statistic 3 Value')
                            ->hint('e.g., 50+')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_3_label')
                            ->label('Statistic 3 Label')
                            ->hint('e.g., Countries Served')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_4_value')
                            ->label('Statistic 4 Value')
                            ->hint('e.g., 100M+')
                            ->columnSpanFull(),

                        \Filament\Forms\Components\TextInput::make('about_stat_4_label')
                            ->label('Statistic 4 Label')
                            ->hint('e.g., Content Views')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($get) => $get('template_type') === 'about')
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'wp-content-section',
                        'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                    ]),






            ],
        ]);
    }
}
