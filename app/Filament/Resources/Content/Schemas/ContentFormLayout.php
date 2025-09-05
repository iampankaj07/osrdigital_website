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
 * Modern Content Management Form Layout
 *
 * Provides a WordPress-style admin interface with:
 * - Clean main content area with tabbed sections
 * - Organized sidebar with meta boxes
 * - Responsive design with proper spacing
 * - Consistent typography and field styling
 */
class ContentFormLayout
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

            // Layout Configuration
            'main_sections' => ['content', 'seo'],
            'sidebar_sections' => ['publish', 'featured_image', 'categories', 'author', 'discussion'],
            'show_tabs' => false,

            // SEO Configuration
            'show_seo' => true,
            'meta_title_max_length' => 60,
            'meta_description_max_length' => 160,
            'meta_description_rows' => 3,
            'show_tags' => true,
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
            'show_featured' => false,
            'show_visibility' => true,

            // Media Configuration
            'show_featured_image' => true,
            'featured_image_label' => 'Featured Image',
            'featured_image_hint' => 'Upload a featured image',
            'featured_image_required' => false,
            'image_aspect_ratios' => ['16:9', '4:3', '1:1'],
            'image_crop_ratio' => '16:9',

            // Categories Configuration
            'show_categories' => true,
            'categories_label' => 'Categories',
            'categories_options' => [],
            'categories_default' => null,
            'categories_required' => false,
            'show_secondary_categories' => false,

            // Author Configuration
            'show_author' => true,
            'author_label' => 'Author',
            'author_default' => 'OSR Digital',
            'author_email_hint' => 'Contact email (optional)',

            // Discussion Configuration
            'show_discussion' => true,
            'discussion_label' => 'Discussion',
            'allow_comments_default' => true,
            'allow_trackbacks_default' => false,

            // Additional Fields
            'additional_fields' => [],
            'custom_sidebar_sections' => [],
        ];

        $config = array_merge($defaults, $config);

        return $schema
            ->columns(1)
            ->components([
                // Header Section (if needed)
                ...(isset($config['header_content']) ? [$config['header_content']] : []),

                // Primary Content Section - Full Width
                Section::make($config['content_label'])
                    ->description('Create and edit your content')
                    ->schema([
                        TextInput::make('title')
                            ->label($config['title_label'])
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $context, $state, callable $set) =>
                                $context === 'create' ? $set('slug', Str::slug($state)) : null
                            )
                            ->placeholder($config['title_placeholder'])
                            ->extraAttributes([
                                'class' => 'text-xl font-semibold',
                                'style' => 'padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px;'
                            ])
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefix(url('/') . $config['slug_prefix'])
                            ->hint('The URL-friendly version of the title')
                            ->extraAttributes(['class' => 'font-mono text-sm'])
                            ->columnSpanFull(),

                        ...(isset($config['show_rich_editor']) && $config['show_rich_editor'] ? [
                            RichEditor::make('content')
                                ->label($config['content_label'])
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
                                ->extraAttributes(['style' => 'min-height: 500px;'])
                                ->columnSpanFull(),
                        ] : []),

                        ...(isset($config['show_description']) && $config['show_description'] ? [
                            Textarea::make('description')
                                ->label($config['content_label'])
                                ->required()
                                ->rows(8)
                                ->placeholder($config['content_placeholder'])
                                ->columnSpanFull(),
                        ] : []),

                        ...(isset($config['show_excerpt']) && $config['show_excerpt'] !== false ? [
                            Textarea::make('excerpt')
                                ->label($config['excerpt_label'])
                                ->maxLength($config['excerpt_max_length'])
                                ->rows($config['excerpt_rows'])
                                ->placeholder($config['excerpt_placeholder'])
                                ->hint($config['excerpt_hint'])
                                ->columnSpanFull(),
                        ] : []),

                        // Additional main content fields
                        ...$config['additional_fields'],
                    ])
                    ->collapsible(false),

                // Settings and Metadata - Organized in Grid
                Grid::make(3)
                    ->schema([
                        // Publish Section
                        Section::make('Publish')
                            ->description('Control publication settings')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options($config['status_options'])
                                    ->default($config['status_default'])
                                    ->required()
                                    ->native(false)
                                    ->columnSpanFull(),

                                DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->default(now())
                                    ->hint('When should this be published?')
                                    ->native(false)
                                    ->columnSpanFull(),

                                ...($config['show_visibility'] ? [
                                    Toggle::make('is_published')
                                        ->label('Visible to Public')
                                        ->hint('Make this visible to website visitors')
                                        ->default(true)
                                        ->inline(false),
                                ] : []),

                                ...($config['show_featured'] ? [
                                    Toggle::make('is_featured')
                                        ->label('Featured')
                                        ->hint('Feature this content')
                                        ->default(false)
                                        ->inline(false),
                                ] : []),
                            ])
                            ->compact(),

                        // Featured Image Section
                        ...($config['show_featured_image'] ? [
                            Section::make($config['featured_image_label'])
                                ->description('Upload media for this content')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    FileUpload::make('featured_image')
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
                                ->compact(),
                        ] : []),

                        // Categories Section
                        ...($config['show_categories'] && !empty($config['categories_options']) ? [
                            Section::make($config['categories_label'])
                                ->description('Organize your content')
                                ->icon('heroicon-o-tag')
                                ->schema([
                                    Select::make('category_id')
                                        ->label('Primary Category')
                                        ->options($config['categories_options'])
                                        ->default($config['categories_default'])
                                        ->required($config['categories_required'])
                                        ->native(false)
                                        ->columnSpanFull(),

                                    ...($config['show_secondary_categories'] ? [
                                        Select::make('secondary_categories')
                                            ->label('Additional Categories')
                                            ->multiple()
                                            ->options($config['categories_options'])
                                            ->native(false)
                                            ->columnSpanFull(),
                                    ] : []),
                                ])
                                ->compact(),
                        ] : []),
                    ]),

                // SEO Section - Full Width
                ...($config['show_seo'] ? [
                    Section::make('SEO & Meta Information')
                        ->description('Optimize for search engines')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('meta_title')
                                        ->label('SEO Title')
                                        ->maxLength($config['meta_title_max_length'])
                                        ->hint('If left blank, the title will be used')
                                        ->extraAttributes(['class' => 'text-sm']),

                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->maxLength($config['meta_description_max_length'])
                                        ->rows($config['meta_description_rows'])
                                        ->hint('Description for search engines (max ' . $config['meta_description_max_length'] . ' characters)')
                                        ->extraAttributes(['class' => 'text-sm']),
                                ]),

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
                        ->collapsed(),
                ] : []),

                // Additional Sections - Full Width Grid
                ...($config['show_author'] || $config['show_discussion'] || !empty($config['custom_sidebar_sections']) ? [
                    Grid::make(2)
                        ->schema([
                            // Author Section
                            ...($config['show_author'] ? [
                                Section::make('Author Information')
                                    ->description('Content author details')
                                    ->icon('heroicon-o-user')
                                    ->schema([
                                        TextInput::make('author_name')
                                            ->label($config['author_label'])
                                            ->required()
                                            ->default($config['author_default'])
                                            ->columnSpanFull(),

                                        TextInput::make('author_email')
                                            ->label('Author Email')
                                            ->email()
                                            ->hint($config['author_email_hint'])
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->collapsed()
                                    ->compact(),
                            ] : []),

                            // Discussion Section
                            ...($config['show_discussion'] ? [
                                Section::make($config['discussion_label'])
                                    ->description('Comment and interaction settings')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->schema([
                                        Toggle::make('allow_comments')
                                            ->label('Allow Comments')
                                            ->hint('Enable comments for this content')
                                            ->default($config['allow_comments_default'])
                                            ->inline(false),

                                        Toggle::make('comment_status')
                                            ->label('Comment Status')
                                            ->hint('Overall comment status')
                                            ->default($config['allow_comments_default'])
                                            ->inline(false),

                                        Toggle::make('ping_status')
                                            ->label('Allow Trackbacks')
                                            ->hint('Allow trackbacks and pingbacks')
                                            ->default($config['allow_trackbacks_default'])
                                            ->inline(false),
                                    ])
                                    ->collapsible()
                                    ->collapsed()
                                    ->compact(),
                            ] : []),

                            // Custom sidebar sections
                            ...$config['custom_sidebar_sections'],
                        ]),
                ] : []),
            ]);
    }
}
