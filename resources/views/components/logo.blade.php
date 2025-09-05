@props(['type' => 'auto', 'class' => ''])

@php
    $logoLight = \App\Helpers\SettingsHelper::get('logo_light');
    $logoDark = \App\Helpers\SettingsHelper::get('logo_dark');
    $logoAdmin = \App\Helpers\SettingsHelper::get('logo_admin');
    $logoMobile = \App\Helpers\SettingsHelper::get('logo_mobile');
    $logoFooter = \App\Helpers\SettingsHelper::get('logo_footer');
    $logoEmail = \App\Helpers\SettingsHelper::get('logo_email');
    $siteName = \App\Helpers\SettingsHelper::getSiteTitle();

    // Determine which logo to show
    if ($type === 'light') {
        $logo = $logoLight;
    } elseif ($type === 'dark') {
        $logo = $logoDark;
    } elseif ($type === 'admin') {
        $logo = $logoAdmin ?? $logoLight ?? $logoDark;
    } elseif ($type === 'mobile') {
        $logo = $logoMobile ?? $logoLight ?? $logoDark;
    } elseif ($type === 'footer') {
        $logo = $logoFooter ?? $logoLight ?? $logoDark;
    } elseif ($type === 'email') {
        $logo = $logoEmail ?? $logoLight ?? $logoDark;
    } else {
        // Auto mode - show appropriate logo for theme
        $logo = null;
    }
@endphp

<div class="logo {{ $class }}">
    @if($type === 'auto' && $logoLight && $logoDark)
        <!-- Show different logos for light/dark themes -->
        <img src="{{ Storage::url($logoLight) }}"
             alt="{{ $siteName }}"
             class="h-8 w-auto block dark:hidden">
        <img src="{{ Storage::url($logoDark) }}"
             alt="{{ $siteName }}"
             class="h-8 w-auto hidden dark:block">
    @elseif($logo)
        <!-- Single logo -->
        <img src="{{ Storage::url($logo) }}"
             alt="{{ $siteName }}"
             class="h-8 w-auto">
    @else
        <!-- Fallback to text -->
        <span class="text-xl font-bold text-gray-900 dark:text-white">
            {{ $siteName }}
        </span>
    @endif
</div>
