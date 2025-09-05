<?php

namespace App\Filament\Resources\Content\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * WordPress-Style Content Management Form Layout
 *
 * Provides a WordPress-style admin interface with:
 * - 70% main content area on the left
 * - 30% sidebar with meta boxes on the right
 * - Clean and organized layout similar to WordPress post editor
 */
class WordPressStyleFormLayout
{
    public static function configure(Schema $schema, array $config = []): Schema
    {
        $defaults = [
            // Content Configuration
            'title_label' => 'Title',
            'title_placeholder' => 'Enter title here...',
            'slug_prefix' => '/',
            'content_label' => 'Content',
            'content_placeholder' => 'Start writing...',
            'excerpt_label' => 'Excerpt',
            'excerpt_max_length' => 500,
            'excerpt_rows' => 4,
            'excerpt_placeholder' => 'Write a brief summary...',
            'excerpt_hint' => 'This will be used for previews and meta descriptions',

            // Show/Hide Configuration
            'show_rich_editor' => true,
            'show_excerpt' => true,
            'show_seo' => true,
            'show_tags' => true,
            'show_featured' => false,
            'show_visibility' => true,
            'show_featured_image' => true,
            'show_categories' => true,
            'show_author' => true,
            'show_discussion' => true,

            // SEO Configuration
            'meta_title_max_length' => 60,
            'meta_description_max_length' => 160,
            'meta_description_rows' => 3,
            'tags_separator' => ',',
            'tags_placeholder' => 'Add tags...',
            'tags_hint' => 'Separate tags with commas',

            // Publish Configuration
            'status_options' => [
                'draft' => 'Draft',
                'pending' => 'Pending Review',
                'published' => 'Published',
                'private' => 'Private',
            ],
            'status_default' => 'draft',

            // Media Configuration
            'featured_image_label' => 'Featured Image',
            'featured_image_hint' => 'Upload a featured image',
            'featured_image_required' => false,
            'image_aspect_ratios' => ['16:9', '4:3', '1:1'],
            'image_crop_ratio' => '16:9',

            // Categories Configuration
            'categories_label' => 'Categories',
            'categories_options' => [],
            'categories_default' => null,
            'categories_required' => false,
            'show_secondary_categories' => false,

            // Author Configuration
            'author_label' => 'Author',
            'author_default' => 'OSR Digital',
            'author_email_hint' => 'Contact email (optional)',

            // Field Mapping Configuration
            'title_field' => 'title',
            'slug_field' => 'slug',
            'content_field' => 'content',
            'excerpt_field' => 'excerpt',
            'featured_image_field' => 'featured_image',
            'categories_field' => 'category',
            'status_field' => 'status',

            // Discussion Configuration
            'discussion_label' => 'Discussion',
            'allow_comments_default' => true,
            'allow_trackbacks_default' => false,
        ];

        $config = array_merge($defaults, $config);

        return $schema
            ->columns(10) // Using 10 columns for precise 70/30 split
            ->components([
                // LEFT SIDE - Main Content Area (70% - 7 columns)
                Grid::make(1)
                    ->columnSpan(7)
                    ->schema([
                        // Title Section
                        Section::make()
                            ->heading(false)
                            ->schema([
                                TextInput::make($config['title_field'])
                                    ->label($config['title_label'])
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $context, $state, callable $set) =>
                                        $context === 'create' ? $set($config['slug_field'], Str::slug($state)) : null
                                    )
                                    ->placeholder($config['title_placeholder'])
                                    ->extraAttributes([
                                        'class' => 'text-2xl font-bold border-0 bg-transparent p-0',
                                        'style' => 'font-size: 1.75rem; line-height: 2.25rem; font-weight: 700; border: none; background: transparent; padding: 0; box-shadow: none;'
                                    ])
                                    ->columnSpanFull(),

                                TextInput::make($config['slug_field'])
                                    ->label('Permalink')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->prefix(url('/') . $config['slug_prefix'])
                                    ->extraAttributes(['class' => 'font-mono text-sm'])
                                    ->columnSpanFull(),
                            ])
                            ->extraAttributes([
                                'class' => 'wp-editor-title-section',
                                'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px;'
                            ]),

                        // Main Content Editor
                        Section::make()
                            ->heading(false)
                            ->schema([
                                ...(isset($config['show_rich_editor']) && $config['show_rich_editor'] ? [
                                    RichEditor::make($config['content_field'])
                                        ->label('')
                                        ->required()
                                        ->toolbarButtons([
                                            'attachFiles',
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'h2',
                                            'h3',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'table',
                                            'underline',
                                            'undo',
                                        ])
                                        ->placeholder($config['content_placeholder'])
                                        ->extraAttributes(['style' => 'min-height: 400px;'])
                                        ->columnSpanFull(),
                                ] : []),

                                ...(isset($config['show_description']) && $config['show_description'] ? [
                                    Textarea::make($config['content_field'])
                                        ->label('')
                                        ->required()
                                        ->rows(12)
                                        ->placeholder($config['content_placeholder'])
                                        ->columnSpanFull(),
                                ] : []),
                            ])
                            ->extraAttributes([
                                'class' => 'wp-editor-content-section',
                                'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin-bottom: 16px;'
                            ]),

                        // Excerpt Section (if enabled)
                        ...($config['show_excerpt'] ? [
                            Section::make('Excerpt')
                                ->description('Write a brief summary of this content')
                                ->schema([
                                    Textarea::make($config['excerpt_field'])
                                        ->label('')
                                        ->maxLength($config['excerpt_max_length'])
                                        ->rows($config['excerpt_rows'])
                                        ->placeholder($config['excerpt_placeholder'])
                                        ->hint($config['excerpt_hint'])
                                        ->columnSpanFull(),
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->extraAttributes([
                                    'class' => 'wp-excerpt-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),

                        // SEO Section (if enabled)
                        ...($config['show_seo'] ? [
                            Section::make('SEO Settings')
                                ->description('Search engine optimization')
                                ->icon('heroicon-o-magnifying-glass')
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('SEO Title')
                                        ->maxLength($config['meta_title_max_length'])
                                        ->hint('If left blank, the title will be used')
                                        ->columnSpanFull(),

                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->maxLength($config['meta_description_max_length'])
                                        ->rows($config['meta_description_rows'])
                                        ->hint('Description for search engines (max ' . $config['meta_description_max_length'] . ' characters)')
                                        ->columnSpanFull(),

                                    ...($config['show_tags'] ? [
                                        TagsInput::make('tags')
                                            ->label('Tags')
                                            ->separator($config['tags_separator'])
                                            ->placeholder($config['tags_placeholder'])
                                            ->hint($config['tags_hint'])
                                            ->columnSpanFull(),
                                    ] : []),
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->extraAttributes([
                                    'class' => 'wp-seo-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),
                    ]),

                // RIGHT SIDE - Sidebar (30% - 3 columns)
                Grid::make(1)
                    ->columnSpan(3)
                    ->schema([
                        // Publish Section
                        Section::make('Publish')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Select::make($config['status_field'])
                                    ->label('Status')
                                    ->options($config['status_options'])
                                    ->default($config['status_default'])
                                    ->required()
                                    ->native(false)
                                    ->columnSpanFull(),

                                ...($config['show_visibility'] ? [
                                    Toggle::make('is_published')
                                        ->label('Visibility')
                                        ->hint('Visible to public')
                                        ->default(true)
                                        ->inline(false),
                                ] : []),

                                DateTimePicker::make('published_at')
                                    ->label('Publish')
                                    ->default(now())
                                    ->native(false)
                                    ->columnSpanFull(),

                                ...($config['show_featured'] ? [
                                    Toggle::make('is_featured')
                                        ->label('Featured')
                                        ->default(false)
                                        ->inline(false),
                                ] : []),
                            ])
                            ->extraAttributes([
                                'class' => 'wp-sidebar-section',
                                'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                            ]),

                        // Featured Image Section
                        ...($config['show_featured_image'] ? [
                            Section::make($config['featured_image_label'])
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    FileUpload::make($config['featured_image_field'])
                                        ->label('')
                                        ->image()
                                        ->imageEditor()
                                        ->imageEditorAspectRatios($config['image_aspect_ratios'])
                                        ->imageResizeMode('cover')
                                        ->imageCropAspectRatio($config['image_crop_ratio'])
                                        ->maxSize(2048)
                                        ->hint($config['featured_image_hint'])
                                        ->required($config['featured_image_required'])
                                        ->columnSpanFull(),
                                ])
                                ->extraAttributes([
                                    'class' => 'wp-sidebar-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),

                        // Categories Section
                        ...($config['show_categories'] && !empty($config['categories_options']) ? [
                            Section::make($config['categories_label'])
                                ->icon('heroicon-o-tag')
                                ->schema([
                                    Select::make($config['categories_field'])
                                        ->label('Primary Category')
                                        ->options($config['categories_options'])
                                        ->default($config['categories_default'])
                                        ->required($config['categories_required'])
                                        ->native(false)
                                        ->columnSpanFull(),

                                    ...($config['show_secondary_categories'] ? [
                                        Select::make('secondary_categories')
                                            ->label('Additional')
                                            ->multiple()
                                            ->options($config['categories_options'])
                                            ->native(false)
                                            ->columnSpanFull(),
                                    ] : []),
                                ])
                                ->extraAttributes([
                                    'class' => 'wp-sidebar-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),

                        // Author Section
                        ...($config['show_author'] ? [
                            Section::make('Author')
                                ->icon('heroicon-o-user')
                                ->schema([
                                    TextInput::make('author_name')
                                        ->label('Name')
                                        ->required()
                                        ->default($config['author_default'])
                                        ->columnSpanFull(),

                                    TextInput::make('author_email')
                                        ->label('Email')
                                        ->email()
                                        ->hint($config['author_email_hint'])
                                        ->columnSpanFull(),
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->extraAttributes([
                                    'class' => 'wp-sidebar-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),

                        // Discussion Section
                        ...($config['show_discussion'] ? [
                            Section::make($config['discussion_label'])
                                ->icon('heroicon-o-chat-bubble-left-right')
                                ->schema([
                                    Toggle::make('allow_comments')
                                        ->label('Allow comments')
                                        ->default($config['allow_comments_default'])
                                        ->inline(false),

                                    Toggle::make('comment_status')
                                        ->label('Comment status')
                                        ->default($config['allow_comments_default'])
                                        ->inline(false),

                                    Toggle::make('ping_status')
                                        ->label('Allow trackbacks')
                                        ->default($config['allow_trackbacks_default'])
                                        ->inline(false),
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->extraAttributes([
                                    'class' => 'wp-sidebar-section',
                                    'style' => 'background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px;'
                                ]),
                        ] : []),
                    ]),
            ]);
    }
}
