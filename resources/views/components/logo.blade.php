@props(['type' => 'auto', 'class' => '', 'width' => null, 'height' => null])

@php
    $logoLight = \App\Helpers\SettingsHelper::logo('light');
    $logoDark = \App\Helpers\SettingsHelper::logo('dark');
    $logoAdmin = \App\Helpers\SettingsHelper::logo('admin');
    $logoMobile = \App\Helpers\SettingsHelper::logo('mobile');
    $logoFooter = \App\Helpers\SettingsHelper::logo('footer');
    $logoEmail = \App\Helpers\SettingsHelper::logo('email');
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
        <img src="{{ $logoLight }}"
             alt="{{ $siteName }}"
             class="{{ $defaultClass }} block dark:hidden"
             @if($style) style="{{ $style }}" @endif>
        <img src="{{ $logoDark }}"
             alt="{{ $siteName }}"
             class="{{ $defaultClass }} hidden dark:block"
             @if($style) style="{{ $style }}" @endif>
    @elseif($logo)
        <!-- Single logo -->
        <img src="{{ $logo }}"
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
