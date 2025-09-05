<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Permission Name')
                    ->helperText('Use dot notation for nested permissions (e.g., users.create, posts.edit)'),
                    
                TextInput::make('guard_name')
                    ->default('web')
                    ->required()
                    ->label('Guard Name'),
            ]);
    }
}
