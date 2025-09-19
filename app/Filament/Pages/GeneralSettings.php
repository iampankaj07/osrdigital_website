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
use Filament\Schemas\Components\Section;
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
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('site_description')
                            ->label('Site Description')
                            ->rows(3)
                            ->maxLength(500),
                        ColorPicker::make('theme_color')
                            ->label('Theme Color')
                            ->default('#3b82f6'),
                    ])
                    ->columns(2),
                
                Section::make('Media')
                    ->schema([
                        FileUpload::make('site_logo')
                            ->label('Site Logo')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                            ->maxSize(2048),
                        FileUpload::make('site_favicon')
                            ->label('Site Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('favicons')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/x-icon', 'image/png'])
                            ->maxSize(1024),
                    ])
                    ->columns(2),
                
                Section::make('Contact Information')
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
                
                Section::make('SEO Settings')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255),
                        TextInput::make('seo_keywords')
                            ->label('SEO Keywords')
                            ->maxLength(500),
                        KeyValue::make('seo_metadata')
                            ->label('SEO Metadata')
                            ->keyLabel('Meta Property')
                            ->valueLabel('Content'),
                    ])
                    ->columns(2),
                
                Section::make('Analytics')
                    ->schema([
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics ID')
                            ->maxLength(255),
                        Textarea::make('posthog_html_snippet')
                            ->label('PostHog HTML Snippet')
                            ->rows(4),
                    ])
                    ->columns(2),
                
                Section::make('Social Networks')
                    ->schema([
                        KeyValue::make('social_network')
                            ->label('Social Network Links')
                            ->keyLabel('Platform')
                            ->valueLabel('URL'),
                    ]),
                
                Section::make('Advanced Settings')
                    ->schema([
                        KeyValue::make('email_settings')
                            ->label('Email Settings')
                            ->keyLabel('Setting')
                            ->valueLabel('Value'),
                        KeyValue::make('more_configs')
                            ->label('Additional Configurations')
                            ->keyLabel('Config Key')
                            ->valueLabel('Config Value'),
                    ])
                    ->collapsible()
                    ->collapsed(true),
            ])
            ->statePath('data');
    }
}
