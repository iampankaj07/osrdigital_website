<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(['movie' => 'Movie', 'music' => 'Music', 'short_film' => 'Short film'])
                    ->required(),
                FileUpload::make('image_url')
                    ->image()
                    ->required(),
                TextInput::make('video_url'),
                TextInput::make('views')
                    ->required()
                    ->default('0'),
                TextInput::make('category'),
                TextInput::make('metadata'),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
