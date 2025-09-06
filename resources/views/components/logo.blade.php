@props(['type' => 'auto', 'class' => '', 'width' => null, 'height' => null])

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

    // Build style attribute for dimensions
    $style = '';
    if ($width) {
        $style .= "width: {$width}px; ";
    }
    if ($height) {
        $style .= "height: {$height}px; ";
    }

    // Default classes for sizing
    $defaultClass = 'h-8 w-auto';
    if ($width || $height) {
        $defaultClass = 'w-auto'; // Remove default height if custom dimensions are set
    }
@endphp

<div class="logo {{ $class }}">
    @if($type === 'auto' && $logoLight && $logoDark)
        <!-- Show different logos for light/dark themes -->
        <img src="{{ Storage::url($logoLight) }}"
             alt="{{ $siteName }}"
             class="{{ $defaultClass }} block dark:hidden"
             @if($style) style="{{ $style }}" @endif>
        <img src="{{ Storage::url($logoDark) }}"
             alt="{{ $siteName }}"
             class="{{ $defaultClass }} hidden dark:block"
             @if($style) style="{{ $style }}" @endif>
    @elseif($logo)
        <!-- Single logo -->
        <img src="{{ Storage::url($logo) }}"
             alt="{{ $siteName }}"
             class="{{ $defaultClass }}"
             @if($style) style="{{ $style }}" @endif>
    @else
        <!-- Fallback to text -->
        <span class="text-xl font-bold text-gray-900 dark:text-white"
              @if($style) style="{{ $style }}" @endif>
            {{ $siteName }}
        </span>
    @endif
</div>
