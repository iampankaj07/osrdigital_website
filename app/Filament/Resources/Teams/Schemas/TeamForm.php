<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash']),

                TextInput::make('position')
                    ->maxLength(255),

                Textarea::make('description')
                    ->rows(3),

                TextInput::make('email')
                    ->email()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->image()
                    ->directory('teams')
                    ->disk('public')
                    ->maxSize(2048)
                    ->imageEditor(),

                Repeater::make('social_links')
                    ->schema([
                        Select::make('platform')
                            ->options([
                                'linkedin' => 'LinkedIn',
                                'twitter' => 'Twitter',
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'github' => 'GitHub',
                                'website' => 'Website',
                            ])
                            ->required(),
                        TextInput::make('url')
                            ->url()
                            ->required()
                            ->placeholder('https://...'),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add Social Link')
                    ->collapsed()
                    ->defaultItems(0),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
