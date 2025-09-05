<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Role Name'),
                    
                TextInput::make('guard_name')
                    ->default('web')
                    ->required()
                    ->label('Guard Name'),
                    
                CheckboxList::make('permissions')
                    ->relationship('permissions', 'name')
                    ->label('Permissions')
                    ->columns(2)
                    ->helperText('Select permissions for this role')
                    ->options(Permission::all()->pluck('name', 'id')),
            ]);
    }
}
