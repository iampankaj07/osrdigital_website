<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;

class WebConfiguration extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Web Configuration';
    protected static ?string $navigationLabel = 'Web Configuration';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getViewName(): string
    {
        return 'filament.pages.web-configuration';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = [
            'logo_light' => Setting::getValue('logo_light'),
            'logo_dark' => Setting::getValue('logo_dark'),
            'logo_admin' => Setting::getValue('logo_admin'),
            'logo_mobile' => Setting::getValue('logo_mobile'),
            'logo_footer' => Setting::getValue('logo_footer'),
            'logo_email' => Setting::getValue('logo_email'),
            'favicon' => Setting::getValue('favicon'),
            'site_title' => Setting::getValue('site_title', config('app.name')),
            'site_description' => Setting::getValue('site_description', ''),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_title')
                ->label('Site Title')
                ->required()
                ->maxLength(255)
                ->placeholder('Enter your website title'),

            Textarea::make('site_description')
                ->label('Site Description')
                ->rows(3)
                ->maxLength(500)
                ->placeholder('Brief description of your website'),

            FileUpload::make('logo_light')
                ->label('Light Mode Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(2048)
                ->helperText('Main logo for light theme/background'),

            FileUpload::make('logo_dark')
                ->label('Dark Mode Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(2048)
                ->helperText('Main logo for dark theme/background'),

            FileUpload::make('logo_admin')
                ->label('Admin Panel Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(2048)
                ->helperText('Logo displayed in the admin panel header'),

            FileUpload::make('logo_mobile')
                ->label('Mobile Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(2048)
                ->helperText('Optimized logo for mobile devices (smaller size)'),

            FileUpload::make('logo_footer')
                ->label('Footer Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(2048)
                ->helperText('Logo for website footer section'),

            FileUpload::make('logo_email')
                ->label('Email Logo')
                ->image()
                ->directory('logos')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                ->maxSize(1024)
                ->helperText('Logo for email templates and newsletters'),

            FileUpload::make('favicon')
                ->label('Favicon')
                ->image()
                ->directory('favicons')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/vnd.microsoft.icon'])
                ->maxSize(512)
                ->helperText('Small icon displayed in browser tabs (16x16 or 32x32)'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Save each setting
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Web configuration updated successfully!')
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Configuration')
                ->action('save')
                ->color('primary'),
        ];
    }
}
