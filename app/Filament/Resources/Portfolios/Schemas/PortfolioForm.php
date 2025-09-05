<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use App\Filament\Resources\Content\Schemas\WordPressStyleFormLayout;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return WordPressStyleFormLayout::configure($schema, [
            // Content Configuration
            'title_label' => 'Project Title',
            'title_placeholder' => 'Enter project title here...',
            'slug_prefix' => '/portfolio/',
            'content_label' => 'Project Description',
            'content_placeholder' => 'Describe your portfolio project...',
            'show_description' => true,
            'show_rich_editor' => false,
            'show_excerpt' => true,
            'excerpt_label' => 'Project Brief',
            'excerpt_placeholder' => 'Brief summary of the project goals and requirements...',
            'excerpt_hint' => 'This will be used for project previews',

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
            'show_featured' => true,
            'show_visibility' => true,

            // Media Configuration
            'show_featured_image' => true,
            'featured_image_label' => 'Featured Image',
            'featured_image_hint' => 'Main image for this portfolio item',
            'featured_image_required' => true,

            // Categories Configuration
            'show_categories' => true,
            'categories_label' => 'Project Type',
            'categories_options' => [
                'web_development' => 'Web Development',
                'mobile_app' => 'Mobile Application',
                'desktop_app' => 'Desktop Application',
                'ui_ux_design' => 'UI/UX Design',
                'branding' => 'Branding & Identity',
                'ecommerce' => 'E-commerce',
                'cms_development' => 'CMS Development',
                'api_development' => 'API Development',
                'maintenance' => 'Website Maintenance',
                'consulting' => 'Consulting',
                'photography' => 'Photography',
                'graphic_design' => 'Graphic Design',
                'movie' => 'Movie/Video',
                'music' => 'Music/Audio',
                'short_film' => 'Short Film',
                'other' => 'Other',
            ],
            'categories_default' => 'web_development',
            'categories_required' => true,
            'show_secondary_categories' => false,

            // Author Configuration
            'show_author' => false,

            // Discussion Configuration
            'show_discussion' => false,

            // Additional Fields in Main Content
            'additional_fields' => [
                Section::make('Project Details')
                    ->description('Specific project information')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('client_name')
                                    ->label('Client Name')
                                    ->placeholder('Client or company name'),

                                DateTimePicker::make('project_date')
                                    ->label('Project Date')
                                    ->default(now())
                                    ->hint('When was this project completed?')
                                    ->native(false),

                                TextInput::make('project_url')
                                    ->label('Live Project URL')
                                    ->url()
                                    ->placeholder('https://example.com'),

                                TextInput::make('github_url')
                                    ->label('GitHub Repository')
                                    ->url()
                                    ->placeholder('https://github.com/user/repo'),
                            ]),

                        TextInput::make('video_url')
                            ->label('Demo Video URL')
                            ->url()
                            ->placeholder('https://youtube.com/watch?v=...')
                            ->hint('YouTube, Vimeo, or direct video link')
                            ->columnSpanFull(),

                        Textarea::make('technologies')
                            ->label('Technologies Used')
                            ->placeholder('Laravel, PHP, JavaScript, Vue.js, MySQL...')
                            ->hint('Technologies and tools used in this project')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Project Gallery')
                    ->description('Additional project images')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('gallery_images')
                            ->label('Project Images')
                            ->image()
                            ->multiple()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->maxSize(2048)
                            ->hint('Upload multiple images to showcase your project')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ],

            // Custom Sidebar Sections
            'custom_sidebar_sections' => [
                Section::make('Project Categories')
                    ->description('Organize your project')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'personal' => 'Personal Project',
                                'client' => 'Client Work',
                                'open_source' => 'Open Source',
                                'commercial' => 'Commercial',
                                'educational' => 'Educational',
                            ])
                            ->default('client')
                            ->native(false)
                            ->columnSpanFull(),

                        Select::make('industry')
                            ->label('Industry')
                            ->options([
                                'technology' => 'Technology',
                                'healthcare' => 'Healthcare',
                                'finance' => 'Finance',
                                'education' => 'Education',
                                'entertainment' => 'Entertainment',
                                'retail' => 'Retail',
                                'nonprofit' => 'Non-profit',
                                'government' => 'Government',
                                'other' => 'Other',
                            ])
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->compact(),

                Section::make('Project Metrics')
                    ->description('Project statistics and details')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('completion_time')
                                    ->label('Duration')
                                    ->placeholder('e.g., 3 months'),

                                Select::make('difficulty_level')
                                    ->label('Difficulty')
                                    ->options([
                                        'beginner' => 'Beginner',
                                        'intermediate' => 'Intermediate',
                                        'advanced' => 'Advanced',
                                        'expert' => 'Expert',
                                    ])
                                    ->native(false),

                                TextInput::make('team_size')
                                    ->label('Team Size')
                                    ->numeric()
                                    ->placeholder('Number of members'),

                                Select::make('project_status')
                                    ->label('Project Status')
                                    ->options([
                                        'completed' => 'Completed',
                                        'in_progress' => 'In Progress',
                                        'on_hold' => 'On Hold',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('completed')
                                    ->native(false),
                            ]),

                        Textarea::make('challenges_solved')
                            ->label('Key Challenges')
                            ->rows(3)
                            ->placeholder('Main challenges overcome...')
                            ->columnSpanFull(),

                        Textarea::make('results_achieved')
                            ->label('Results Achieved')
                            ->rows(3)
                            ->placeholder('Outcomes and achievements...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),

                Section::make('Advanced Settings')
                    ->description('Additional project settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextInput::make('views')
                            ->label('Views')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->hint('Total project views'),

                        TextInput::make('likes')
                            ->label('Likes')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->hint('Number of likes received'),

                        Textarea::make('custom_css')
                            ->label('Custom CSS')
                            ->rows(5)
                            ->placeholder('/* Custom CSS for this project only */')
                            ->hint('Project-specific styling'),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),
            ],
        ]);
    }
}
