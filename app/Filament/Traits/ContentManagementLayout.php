<?php

namespace App\Filament\Traits;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

trait ContentManagementLayout
{
    public static function getMainContentSection(): array
    {
        return [
            Section::make('Content')
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null)
                        ->placeholder('Enter title here...')
                        ->extraAttributes(['class' => 'text-lg font-semibold'])
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->label('URL Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->prefix(url('/') . '/')
                        ->hint('The URL-friendly version of the title')
                        ->columnSpanFull(),

                    RichEditor::make('content')
                        ->label('Content')
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
                        ->placeholder('Start writing your content...')
                        ->columnSpanFull(),

                    Textarea::make('excerpt')
                        ->label('Excerpt')
                        ->maxLength(500)
                        ->rows(4)
                        ->placeholder('Optional summary of your content...')
                        ->hint('Brief description for previews and SEO')
                        ->columnSpanFull(),
                ])
                ->columnSpan(8),
        ];
    }

    public static function getSeoSection(): array
    {
        return [
            Section::make('SEO Settings')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('SEO Title')
                        ->maxLength(60)
                        ->hint('If left blank, the main title will be used')
                        ->columnSpanFull(),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->maxLength(160)
                        ->rows(3)
                        ->hint('Description for search engines (max 160 characters)')
                        ->columnSpanFull(),

                    TagsInput::make('tags')
                        ->label('Keywords/Tags')
                        ->separator(',')
                        ->placeholder('Add keywords...')
                        ->hint('Separate keywords with commas')
                        ->columnSpanFull(),
                ])
                ->columnSpan(8)
                ->collapsible()
                ->collapsed(),
        ];
    }

    public static function getPublishSection(): array
    {
        return [
            Section::make('Publish')
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft' => 'Draft',
                            'pending' => 'Pending Review',
                            'published' => 'Published',
                            'scheduled' => 'Scheduled',
                            'private' => 'Private',
                        ])
                        ->default('draft')
                        ->required()
                        ->columnSpanFull(),

                    DateTimePicker::make('published_at')
                        ->label('Publish Date')
                        ->default(now())
                        ->hint('When should this be published?')
                        ->columnSpanFull(),

                    Toggle::make('is_featured')
                        ->label('Featured')
                        ->hint('Feature this content')
                        ->default(false),

                    Toggle::make('is_published')
                        ->label('Visible to Public')
                        ->hint('Make this visible to website visitors')
                        ->default(true),
                ])
                ->columnSpan(4),
        ];
    }

    public static function getFeaturedImageSection(): array
    {
        return [
            Section::make('Featured Image')
                ->schema([
                    FileUpload::make('featured_image')
                        ->label('')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->maxSize(2048)
                        ->hint('Upload a featured image')
                        ->columnSpanFull(),
                ])
                ->columnSpan(4),
        ];
    }

    public static function getCategoriesSection($categories = [], $defaultCategory = 1): array
    {
        return [
            Section::make('Categories')
                ->schema([
                    Select::make('category_id')
                        ->label('Primary Category')
                        ->options($categories ?: [
                            1 => 'Uncategorized',
                            2 => 'Technology',
                            3 => 'Business',
                            4 => 'Entertainment',
                            5 => 'Sports',
                            6 => 'Health',
                            7 => 'Politics',
                            8 => 'Science',
                        ])
                        ->default($defaultCategory)
                        ->required()
                        ->columnSpanFull(),

                    Select::make('secondary_categories')
                        ->label('Additional Categories')
                        ->multiple()
                        ->options($categories ?: [
                            2 => 'Technology',
                            3 => 'Business',
                            4 => 'Entertainment',
                            5 => 'Sports',
                            6 => 'Health',
                            7 => 'Politics',
                            8 => 'Science',
                        ])
                        ->columnSpanFull(),
                ])
                ->columnSpan(4),
        ];
    }

    public static function getAuthorSection(): array
    {
        return [
            Section::make('Author Information')
                ->schema([
                    TextInput::make('author_name')
                        ->label('Author')
                        ->required()
                        ->default('OSR Digital')
                        ->columnSpanFull(),

                    TextInput::make('author_email')
                        ->label('Author Email')
                        ->email()
                        ->hint('Contact email (optional)')
                        ->columnSpanFull(),
                ])
                ->columnSpan(4)
                ->collapsible()
                ->collapsed(),
        ];
    }

    public static function getDiscussionSection(): array
    {
        return [
            Section::make('Discussion Settings')
                ->schema([
                    Toggle::make('allow_comments')
                        ->label('Allow Comments')
                        ->hint('Enable comments for this content')
                        ->default(true),

                    Toggle::make('ping_status')
                        ->label('Allow Trackbacks')
                        ->hint('Allow trackbacks and pingbacks')
                        ->default(false),
                ])
                ->columnSpan(4)
                ->collapsible()
                ->collapsed(),
        ];
    }

    public static function getAdvancedSection(): array
    {
        return [
            Section::make('Advanced Settings')
                ->schema([
                    TextInput::make('custom_css_class')
                        ->label('CSS Class')
                        ->hint('Additional CSS class for styling')
                        ->columnSpanFull(),

                    Textarea::make('custom_css')
                        ->label('Custom CSS')
                        ->rows(5)
                        ->hint('Custom CSS for this content only')
                        ->columnSpanFull(),

                    TextInput::make('menu_order')
                        ->label('Order')
                        ->numeric()
                        ->default(0)
                        ->hint('Sort order (0 = alphabetical)')
                        ->columnSpanFull(),
                ])
                ->columnSpan(4)
                ->collapsible()
                ->collapsed(),
        ];
    }
}
