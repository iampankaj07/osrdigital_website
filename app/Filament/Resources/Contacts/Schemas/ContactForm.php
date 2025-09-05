<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('company'),
                Select::make('type')
                    ->options([
            'general' => 'General',
            'partnership' => 'Partnership',
            'content' => 'Content',
            'support' => 'Support',
            'media' => 'Media',
        ])
                    ->default('general')
                    ->required(),
                Select::make('status')
                    ->options([
            'new' => 'New',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'archived' => 'Archived',
        ])
                    ->default('new')
                    ->required(),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
                DateTimePicker::make('read_at'),
            ]);
    }
}
