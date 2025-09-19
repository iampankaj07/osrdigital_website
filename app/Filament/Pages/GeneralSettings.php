<?php

namespace App\Filament\Pages;

use BackedEnum;
use UnitEnum;
use Inerba\DbConfig\AbstractPageSettings;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Illuminate\Support\Facades\DB;

class GeneralSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'General Settings';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $slug = 'general-settings';

    protected string $view = 'filament.pages.general-settings';

    protected function settingName(): string
    {
        return 'general';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        // Try to get data from the old general_settings table if it exists
        try {
            if (DB::getSchemaBuilder()->hasTable('general_settings')) {
                $settings = DB::table('general_settings')->first();
                if ($settings) {
                    return [
                        'site_name' => $settings->site_name ?? 'OSR Digital',
                        'site_description' => $settings->site_description ?? 'Your digital partner',
                        'site_logo' => $settings->site_logo,
                        'site_favicon' => $settings->site_favicon,
                        'theme_color' => $settings->theme_color ?? '#3b82f6',
                        'support_email' => $settings->support_email,
                        'support_phone' => $settings->support_phone,
                        'google_analytics_id' => $settings->google_analytics_id,
                        'posthog_html_snippet' => $settings->posthog_html_snippet,
                        'seo_title' => $settings->seo_title,
                        'seo_keywords' => $settings->seo_keywords,
                        'seo_metadata' => $settings->seo_metadata ? json_decode($settings->seo_metadata, true) : [],
                        'email_settings' => $settings->email_settings ? json_decode($settings->email_settings, true) : [],
                        'email_from_address' => $settings->email_from_address,
                        'email_from_name' => $settings->email_from_name,
                        'social_network' => $settings->social_network ? json_decode($settings->social_network, true) : [],
                        'more_configs' => $settings->more_configs ? json_decode($settings->more_configs, true) : [],
                    ];
                }
            }
        } catch (\Exception $e) {
            // If there's any error, continue with defaults
        }

        return [
            'site_name' => 'OSR Digital',
            'site_description' => 'Your digital partner',
            'theme_color' => '#3b82f6',
            // Partners page defaults
            'partners_badge' => 'Our Network',
            'partners_title' => 'Strategic Content Partners',
            'partners_description' => 'We collaborate with exceptional creators, studios, and distributors worldwide to bring diverse, high-quality content to global audiences through strategic partnerships.',
            'partnership_categories_title' => 'Partnership Categories',
            'partnership_categories_subtitle' => 'We work with different types of partners to create a comprehensive content ecosystem',
            'studios_title' => 'Studios',
            'studios_description' => 'Creative powerhouses that bring stories to life through exceptional production quality.',
            'studios_count' => '25+',
            'creators_title' => 'Creators',
            'creators_description' => 'Visionary artists and content creators who shape the future of entertainment.',
            'creators_count' => '150+',
            'distributors_title' => 'Distributors',
            'distributors_description' => 'Strategic partners ensuring content reaches audiences across multiple platforms.',
            'distributors_count' => '40+',
            'platforms_title' => 'Platforms',
            'platforms_description' => 'Digital and traditional platforms that amplify our content worldwide.',
            'platforms_count' => '20+',
            'associates_title' => 'Our Associates',
            // Repeater field defaults
            'partnership_categories_items' => [
                [
                    'title' => 'Studios',
                    'description' => 'Creative powerhouses that bring stories to life through exceptional production quality.',
                    'count_display' => '25+',
                    'icon' => '🎬',
                    'image' => null,
                ],
                [
                    'title' => 'Creators',
                    'description' => 'Visionary artists and content creators who shape the future of entertainment.',
                    'count_display' => '150+',
                    'icon' => '🎨',
                    'image' => null,
                ],
                [
                    'title' => 'Distributors',
                    'description' => 'Strategic partners ensuring content reaches audiences across multiple platforms.',
                    'count_display' => '40+',
                    'icon' => '🌍',
                    'image' => null,
                ],
                [
                    'title' => 'Platforms',
                    'description' => 'Digital and traditional platforms that amplify our content worldwide.',
                    'count_display' => '20+',
                    'icon' => '📺',
                    'image' => null,
                ],
            ],
            'associates_items' => [
                [
                    'name' => 'TechCorp Productions',
                    'description' => 'Leading technology solutions for media production',
                    'category' => 'Technology',
                    'website' => 'https://techcorp.com',
                    'logo' => null,
                ],
                [
                    'name' => 'Creative Studios Alliance',
                    'description' => 'Network of independent creative studios',
                    'category' => 'Creative',
                    'website' => 'https://creativestudios.com',
                    'logo' => null,
                ],
                [
                    'name' => 'Global Distribution Network',
                    'description' => 'Worldwide content distribution platform',
                    'category' => 'Distribution',
                    'website' => 'https://globaldist.com',
                    'logo' => null,
                ],
            ],
            // Business page defaults
            'business_page_title' => 'Our Business Model',
            'business_page_description' => 'OSR Digital operates at the intersection of content creation and digital distribution, providing comprehensive solutions for content monetization and audience growth.',
            'business_what_we_do_title' => 'What We Do',
            'business_what_we_do_subtitle' => 'Our comprehensive suite of services covers every aspect of digital content distribution',
            'business_process_title' => 'Our Process',
            'business_process_subtitle' => 'From discovery to distribution, we handle every step of the content journey',
            'business_what_we_do_items' => json_encode([
                [
                    'icon' => '🎬',
                    'title' => 'Rights Acquisition',
                    'description' => 'We identify and acquire distribution rights to exceptional movies, music, and short films from creators worldwide, ensuring fair compensation and global reach.'
                ],
                [
                    'icon' => '📺',
                    'title' => 'YouTube Publishing',
                    'description' => 'Strategic publishing on YouTube with optimized metadata, thumbnails, and scheduling to maximize viewership and engagement across different time zones and audiences.'
                ],
                [
                    'icon' => '📊',
                    'title' => 'Analytics & Optimization',
                    'description' => 'Comprehensive analytics tracking and performance optimization to ensure maximum revenue generation and audience growth for all distributed content.'
                ],
                [
                    'icon' => '🎵',
                    'title' => 'Music Distribution',
                    'description' => 'Specialized music publishing services including playlist placement, social media promotion, and cross-platform distribution strategies.'
                ],
                [
                    'icon' => '🤝',
                    'title' => 'Creator Partnerships',
                    'description' => 'Long-term partnerships with content creators, providing ongoing support, marketing assistance, and revenue optimization strategies.'
                ],
                [
                    'icon' => '🌍',
                    'title' => 'Global Reach',
                    'description' => 'Leveraging our network and expertise to distribute content to global audiences, breaking geographical barriers and cultural boundaries.'
                ]
            ]),
            'business_process_items' => json_encode([
                [
                    'step' => 1,
                    'title' => 'Content Discovery & Evaluation',
                    'description' => 'Our team actively scouts for exceptional content across various platforms and networks, evaluating potential based on quality, audience appeal, and market viability.'
                ],
                [
                    'step' => 2,
                    'title' => 'Rights Negotiation & Acquisition',
                    'description' => 'We work directly with creators, studios, and rights holders to negotiate fair and beneficial distribution agreements that protect creator interests while maximizing reach.'
                ],
                [
                    'step' => 3,
                    'title' => 'Content Optimization & Strategy',
                    'description' => 'Each piece of content undergoes strategic optimization including metadata enhancement, thumbnail design, and audience targeting to ensure maximum engagement.'
                ],
                [
                    'step' => 4,
                    'title' => 'Publication & Promotion',
                    'description' => 'Strategic publishing across our network of channels with coordinated promotional campaigns across social media platforms and industry networks.'
                ],
                [
                    'step' => 5,
                    'title' => 'Performance Monitoring & Revenue Sharing',
                    'description' => 'Continuous monitoring of performance metrics with transparent reporting and fair revenue sharing based on predetermined agreements.'
                ]
            ]),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->icon('heroicon-m-cog-6-tooth')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('site_description')
                                    ->label('Site Description')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                ColorPicker::make('theme_color')
                                    ->label('Theme Color')
                                    ->default('#3b82f6'),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Media')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                FileUpload::make('site_logo')
                                    ->label('Site Logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('logos')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                                    ->maxSize(2048)
                                    ->columnSpanFull(),
                                FileUpload::make('site_favicon')
                                    ->label('Site Favicon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('favicons')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/x-icon', 'image/png'])
                                    ->maxSize(1024)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Contact')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                TextInput::make('support_email')
                                    ->label('Support Email')
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('support_phone')
                                    ->label('Support Phone')
                                    ->tel()
                                    ->maxLength(50),
                                TextInput::make('email_from_address')
                                    ->label('Email From Address')
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('email_from_name')
                                    ->label('Email From Name')
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('SEO')
                            ->icon('heroicon-m-magnifying-glass')
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('SEO Title')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('seo_keywords')
                                    ->label('SEO Keywords')
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                KeyValue::make('seo_metadata')
                                    ->label('SEO Metadata')
                                    ->keyLabel('Meta Property')
                                    ->valueLabel('Content')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Analytics')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('posthog_html_snippet')
                                    ->label('PostHog HTML Snippet')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tabs\Tab::make('Social')
                            ->icon('heroicon-m-share')
                            ->schema([
                                KeyValue::make('social_network')
                                    ->label('Social Network Links')
                                    ->keyLabel('Platform')
                                    ->valueLabel('URL')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Business')
                            ->icon('heroicon-m-briefcase')
                            ->schema([
                                Section::make('Page Header')
                                    ->schema([
                                        TextInput::make('business_page_title')
                                            ->label('Page Title')
                                            ->default('Our Business Model')
                                            ->maxLength(255),
                                        Textarea::make('business_page_description')
                                            ->label('Page Description')
                                            ->default('OSR Digital operates at the intersection of content creation and digital distribution, providing comprehensive solutions for content monetization and audience growth.')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        TextInput::make('business_what_we_do_title')
                                            ->label('What We Do Section Title')
                                            ->default('What We Do')
                                            ->maxLength(255),
                                        Textarea::make('business_what_we_do_subtitle')
                                            ->label('What We Do Section Subtitle')
                                            ->default('Our comprehensive suite of services covers every aspect of digital content distribution')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('business_process_title')
                                            ->label('Process Section Title')
                                            ->default('Our Process')
                                            ->maxLength(255),
                                        Textarea::make('business_process_subtitle')
                                            ->label('Process Section Subtitle')
                                            ->default('From discovery to distribution, we handle every step of the content journey')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Section::make('What We Do Items')
                                    ->schema([
                                        Textarea::make('business_what_we_do_items')
                                            ->label('What We Do Items (JSON)')
                                            ->placeholder('Enter JSON data for What We Do items')
                                            ->rows(15)
                                            ->columnSpanFull()
                                            ->helperText('Format: [{"icon": "🎬", "title": "Title", "description": "Description"}]'),
                                    ]),
                                Section::make('Process Items')
                                    ->schema([
                                        Textarea::make('business_process_items')
                                            ->label('Process Items (JSON)')
                                            ->placeholder('Enter JSON data for Process items')
                                            ->rows(15)
                                            ->columnSpanFull()
                                            ->helperText('Format: [{"step": 1, "title": "Title", "description": "Description"}]'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Partners')
                            ->icon('heroicon-m-building-office-2')
                            ->schema([
                                Tabs::make('Partners Content')
                                    ->tabs([
                                        Tabs\Tab::make('Page Settings')
                                            ->icon('heroicon-m-document-text')
                                            ->schema([
                                                Section::make('Page Content')
                                                    ->schema([
                                                        TextInput::make('partners_badge')
                                                            ->label('Partners Badge')
                                                            ->default('Our Network')
                                                            ->maxLength(255),
                                                        TextInput::make('partners_title')
                                                            ->label('Partners Title')
                                                            ->default('Strategic Content Partners')
                                                            ->maxLength(255),
                                                        Textarea::make('partners_description')
                                                            ->label('Partners Description')
                                                            ->default('We collaborate with exceptional creators, studios, and distributors worldwide to bring diverse, high-quality content to global audiences through strategic partnerships.')
                                                            ->rows(3)
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns(2),
                                            ]),

                                        Tabs\Tab::make('Partnership Categories')
                                            ->icon('heroicon-m-squares-2x2')
                                            ->schema([
                                                Section::make('Categories Section')
                                                    ->schema([
                                                        TextInput::make('partnership_categories_title')
                                                            ->label('Categories Section Title')
                                                            ->default('Partnership Categories')
                                                            ->maxLength(255),
                                                        Textarea::make('partnership_categories_subtitle')
                                                            ->label('Categories Section Subtitle')
                                                            ->default('We work with different types of partners to create a comprehensive content ecosystem')
                                                            ->rows(2)
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns(2),
                                                Section::make('Partnership Categories')
                                                    ->schema([
                                                        Repeater::make('partnership_categories_items')
                                                            ->label('Partnership Categories')
                                                            ->schema([
                                                                FileUpload::make('image')
                                                                    ->label('Category Image')
                                                                    ->image()
                                                                    ->disk('public')
                                                                    ->directory('partners/categories')
                                                                    ->visibility('public')
                                                                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                                                                    ->maxSize(2048)
                                                                    ->columnSpan(1),
                                                                TextInput::make('icon')
                                                                    ->label('Icon (Emoji or Icon Class)')
                                                                    ->maxLength(50)
                                                                    ->placeholder('🎬 or heroicon-o-film')
                                                                    ->columnSpan(1),
                                                                TextInput::make('title')
                                                                    ->label('Category Title')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->columnSpan(1),
                                                                TextInput::make('count_display')
                                                                    ->label('Count Display')
                                                                    ->placeholder('25+')
                                                                    ->maxLength(20)
                                                                    ->columnSpan(1),
                                                                Textarea::make('description')
                                                                    ->label('Category Description')
                                                                    ->required()
                                                                    ->rows(3)
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(2)
                                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                                            ->collapsed()
                                                            ->cloneable()
                                                            ->reorderable()
                                                            ->columnSpanFull()
                                                            ->minItems(1)
                                                            ->maxItems(8),
                                                    ]),
                                            ]),

                                        Tabs\Tab::make('Our Associates')
                                            ->icon('heroicon-m-user-group')
                                            ->schema([
                                                Section::make('Associates Section')
                                                    ->schema([
                                                        TextInput::make('associates_title')
                                                            ->label('Associates Title')
                                                            ->default('Our Associates')
                                                            ->maxLength(255)
                                                            ->columnSpanFull(),
                                                    ]),
                                                Section::make('Associates')
                                                    ->schema([
                                                        Repeater::make('associates_items')
                                                            ->label('Associates')
                                                            ->schema([
                                                                FileUpload::make('logo')
                                                                    ->label('Company Logo')
                                                                    ->image()
                                                                    ->disk('public')
                                                                    ->directory('partners/associates')
                                                                    ->visibility('public')
                                                                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                                                                    ->maxSize(2048)
                                                                    ->columnSpan(1),
                                                                TextInput::make('name')
                                                                    ->label('Company Name')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->columnSpan(1),
                                                                TextInput::make('category')
                                                                    ->label('Category')
                                                                    ->placeholder('Technology, Creative, Distribution, etc.')
                                                                    ->maxLength(100)
                                                                    ->columnSpan(1),
                                                                TextInput::make('website')
                                                                    ->label('Website URL')
                                                                    ->url()
                                                                    ->placeholder('https://example.com')
                                                                    ->columnSpan(1),
                                                                Textarea::make('description')
                                                                    ->label('Description')
                                                                    ->required()
                                                                    ->rows(3)
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(2)
                                                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                                            ->collapsed()
                                                            ->cloneable()
                                                            ->reorderable()
                                                            ->columnSpanFull()
                                                            ->minItems(1)
                                                            ->maxItems(20),
                                                    ]),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Advanced')
                            ->icon('heroicon-m-wrench-screwdriver')
                            ->schema([
                                KeyValue::make('email_settings')
                                    ->label('Email Settings')
                                    ->keyLabel('Setting')
                                    ->valueLabel('Value')
                                    ->columnSpanFull(),
                                KeyValue::make('more_configs')
                                    ->label('Additional Configurations')
                                    ->keyLabel('Config Key')
                                    ->valueLabel('Config Value')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
}
