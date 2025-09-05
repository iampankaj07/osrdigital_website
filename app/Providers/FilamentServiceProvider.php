<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make('User Management')
                    ->label('User Management')
                    ->icon('heroicon-o-user-group')
                    ->collapsed(),
                NavigationGroup::make('Content Management')
                    ->label('Content Management')
                    ->icon('heroicon-o-document-text')
                    ->collapsed(),
                NavigationGroup::make('Communication')
                    ->label('Communication')
                    ->icon('heroicon-o-envelope')
                    ->collapsed(),
                NavigationGroup::make('System')
                    ->label('System')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ]);
        });
    }
}
