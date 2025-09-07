<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Setting Details')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Unique identifier for this setting'),

                        Select::make('group')
                            ->required()
                            ->options([
                                'general' => 'General',
                                'homepage' => 'Homepage Content',
                                'hero' => 'Hero Section',
                                'stats' => 'Statistics',
                                'cta' => 'Call to Action',
                                'branding' => 'Branding',
                                'contact' => 'Contact Information',
                                'social' => 'Social Media',
                                'seo' => 'SEO Settings',
                            ])
                            ->default('general'),

                        Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'boolean' => 'Boolean',
                                'integer' => 'Integer',
                                'float' => 'Float',
                                'json' => 'JSON',
                                'url' => 'URL',
                                'email' => 'Email',
                                'color' => 'Color',
                            ])
                            ->default('text')
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('value', null)),

                        TextInput::make('description')
                            ->maxLength(255)
                            ->helperText('Brief description of what this setting controls'),

                        Toggle::make('is_public')
                            ->default(false)
                            ->helperText('Whether this setting should be available to frontend'),
                    ]),

                Section::make('Setting Value')
                    ->schema([
                        TextInput::make('value')
                            ->label('Value')
                            ->visible(fn ($get): bool => in_array($get('type'), ['text', 'url', 'email']))
                            ->required(fn ($get): bool => in_array($get('type'), ['text', 'url', 'email'])),

                        Textarea::make('value')
                            ->label('Value')
                            ->rows(4)
                            ->visible(fn ($get): bool => $get('type') === 'textarea')
                            ->required(fn ($get): bool => $get('type') === 'textarea'),

                        Toggle::make('value')
                            ->label('Value')
                            ->visible(fn ($get): bool => $get('type') === 'boolean')
                            ->required(fn ($get): bool => $get('type') === 'boolean'),

                        TextInput::make('value')
                            ->label('Value')
                            ->numeric()
                            ->visible(fn ($get): bool => in_array($get('type'), ['integer', 'float']))
                            ->required(fn ($get): bool => in_array($get('type'), ['integer', 'float'])),

                        ColorPicker::make('value')
                            ->label('Value')
                            ->visible(fn ($get): bool => $get('type') === 'color')
                            ->required(fn ($get): bool => $get('type') === 'color'),

                        Textarea::make('value')
                            ->label('JSON Value')
                            ->rows(6)
                            ->visible(fn ($get): bool => $get('type') === 'json')
                            ->required(fn ($get): bool => $get('type') === 'json')
                            ->helperText('Enter valid JSON format'),
                    ]),
            ]);
    }
}
