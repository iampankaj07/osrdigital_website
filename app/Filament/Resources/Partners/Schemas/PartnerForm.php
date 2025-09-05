<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Filament\Resources\Content\Schemas\WordPressStyleFormLayout;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return WordPressStyleFormLayout::configure($schema, [
            // Content Configuration
            'title_label' => 'Partner Name',
            'title_placeholder' => 'Enter partner name here...',
            'slug_prefix' => '/partners/',
            'content_label' => 'Partner Description',
            'content_placeholder' => 'Describe this partner and the partnership...',
            'show_description' => true,
            'show_rich_editor' => false,
            'show_excerpt' => false,

            // Layout Configuration
            'show_seo' => false,
            'show_tags' => false,

            // Publishing Configuration
            'status_options' => [
                'draft' => 'Draft',
                'published' => 'Published',
                'private' => 'Private',
            ],
            'status_default' => 'published',
            'show_featured' => false,
            'show_visibility' => false,

            // Media Configuration
            'show_featured_image' => true,
            'featured_image_label' => 'Partner Logo',
            'featured_image_hint' => 'Upload partner logo (recommended size: 300x150px)',
            'featured_image_required' => true,
            'featured_image_field' => 'logo_url',

            // Categories Configuration (using as partnership type)
            'show_categories' => true,
            'categories_label' => 'Partnership Type',
            'categories_options' => [
                'creator' => 'Creator',
                'distributor' => 'Distributor',
                'studio' => 'Studio',
                'platform' => 'Platform',
                'technology' => 'Technology Partner',
                'strategic' => 'Strategic Partner',
                'vendor' => 'Vendor',
                'affiliate' => 'Affiliate',
            ],
            'categories_default' => 'partner',
            'categories_required' => true,
            'categories_field' => 'partnership_type',
            'show_secondary_categories' => false,

            // Author Configuration
            'show_author' => false,

            // Discussion Configuration
            'show_discussion' => false,

            // Additional Fields in Main Content
            'additional_fields' => [
                Section::make('Contact Information')
                    ->description('Partner contact details')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('website_url')
                                    ->label('Website URL')
                                    ->url()
                                    ->placeholder('https://partner-website.com')
                                    ->hint('Partner\'s official website'),

                                TextInput::make('contact_email')
                                    ->label('Contact Email')
                                    ->email()
                                    ->placeholder('contact@partner.com')
                                    ->hint('Primary contact email'),
                            ]),
                    ])
                    ->collapsible(),
            ],

            // Custom Sidebar Sections
            'custom_sidebar_sections' => [
                Section::make('Partner Status')
                    ->description('Control partner visibility')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active Partner')
                            ->default(true)
                            ->hint('Show this partner on the website')
                            ->columnSpanFull(),
                    ])
                    ->compact(),

                Section::make('Display Order')
                    ->description('Control partner ordering')
                    ->icon('heroicon-o-arrows-up-down')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->hint('Lower numbers appear first')
                            ->columnSpanFull(),
                    ])
                    ->compact(),

                Section::make('Partnership Details')
                    ->description('Additional partnership information')
                    ->icon('heroicon-o-handshake')
                    ->schema([
                        Select::make('partnership_level')
                            ->label('Partnership Level')
                            ->options([
                                'bronze' => 'Bronze Partner',
                                'silver' => 'Silver Partner',
                                'gold' => 'Gold Partner',
                                'platinum' => 'Platinum Partner',
                                'premier' => 'Premier Partner',
                            ])
                            ->native(false)
                            ->columnSpanFull(),

                        TextInput::make('partnership_since')
                            ->label('Partnership Since')
                            ->placeholder('e.g., 2020')
                            ->hint('Year partnership began')
                            ->columnSpanFull(),

                        Textarea::make('partnership_benefits')
                            ->label('Partnership Benefits')
                            ->rows(3)
                            ->placeholder('What benefits does this partnership provide...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),

                Section::make('Social Media')
                    ->description('Partner social media links')
                    ->icon('heroicon-o-share')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->placeholder('https://facebook.com/partner'),

                        TextInput::make('twitter_url')
                            ->label('Twitter/X')
                            ->url()
                            ->placeholder('https://twitter.com/partner'),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->placeholder('https://linkedin.com/company/partner'),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/partner'),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->compact(),
            ],

            // Field Mappings for existing Partner model
            'title_field' => 'name',
            'content_field' => 'description',
        ]);
    }
}
