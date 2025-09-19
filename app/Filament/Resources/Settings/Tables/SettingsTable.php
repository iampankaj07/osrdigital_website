<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Setting Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('group')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'branding' => 'info',
                        'theme' => 'success',
                        'general' => 'gray',
                        'header' => 'warning',
                        'footer' => 'warning',
                        'social' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'file', 'image' => 'success',
                        'boolean' => 'info',
                        'text', 'textarea' => 'gray',
                        'url', 'email' => 'warning',
                        'color' => 'danger',
                        default => 'gray',
                    }),

                ImageColumn::make('file_path')
                    ->label('Preview')
                    ->disk('public')
                    ->visible(function ($record) {
                        return $record && in_array($record->type ?? '', ['file', 'image']);
                    })
                    ->height(50)
                    ->width(50),

                TextColumn::make('value')
                    ->label('Value')
                    ->limit(30)
                    ->visible(function ($record) {
                        return $record && !in_array($record->type ?? '', ['file', 'image']);
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if (!$record || !$record->type) return $state;
                        return match ($record->type) {
                            'boolean' => $state ? 'Yes' : 'No',
                            'color' => $state,
                            default => $state,
                        };
                    }),

                IconColumn::make('is_public')
                    ->label('Frontend')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash'),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Category')
                    ->options([
                        'branding' => 'Branding',
                        'theme' => 'Theme',
                        'general' => 'General',
                        'header' => 'Header',
                        'footer' => 'Footer',
                        'social' => 'Social Media',
                    ]),

                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Long Text',
                        'file' => 'File Upload',
                        'image' => 'Image Upload',
                        'boolean' => 'Yes/No Toggle',
                        'url' => 'URL',
                        'email' => 'Email',
                        'color' => 'Color',
                    ]),

                SelectFilter::make('is_public')
                    ->label('Visibility')
                    ->options([
                        '1' => 'Frontend Visible',
                        '0' => 'Admin Only',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group', 'asc');
    }
}
