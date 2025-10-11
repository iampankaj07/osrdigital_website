<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoSettings = \App\Helpers\ThemeHelper::seo();
        $siteTitle = \App\Helpers\SettingsHelper::getSiteTitle();
        $siteDescription = \App\Helpers\SettingsHelper::getSiteDescription();
        $logoUrl = \App\Helpers\ThemeHelper::logo();
        $faviconUrl = \App\Helpers\ThemeHelper::favicon();
    @endphp

    <!-- Primary Meta Tags -->
    <title>{{ $seoSettings['title'] ?: $siteTitle }}</title>
    <meta name="title" content="{{ $seoSettings['title'] ?: $siteTitle }}">
    <meta name="description" content="{{ $siteDescription }}">

    @if($seoSettings['keywords'])
    <meta name="keywords" content="{{ $seoSettings['keywords'] }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seoSettings['title'] ?: $siteTitle }}">
    <meta property="og:description" content="{{ $siteDescription }}">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seoSettings['title'] ?: $siteTitle }}">
    <meta property="twitter:description" content="{{ $siteDescription }}">
    @if($logoUrl)
    <meta property="twitter:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Additional SEO Metadata -->
    @if(!empty($seoSettings['metadata']))
        @foreach($seoSettings['metadata'] as $property => $content)
            @if($content)
    <meta property="{{ $property }}" content="{{ $content }}">
            @endif
        @endforeach
    @endif

    <!-- Favicon -->
    @if($faviconUrl)
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @php
        $analyticsSettings = \App\Helpers\ThemeHelper::analytics();
    @endphp

    <!-- Google Analytics -->
    @if(!empty($analyticsSettings['google_analytics_id']))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsSettings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $analyticsSettings['google_analytics_id'] }}');
    </script>
    @endif

    <!-- PostHog Analytics -->
    @if(!empty($analyticsSettings['posthog_html_snippet']))
    {!! $analyticsSettings['posthog_html_snippet'] !!}
    @endif

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body>
    <div id="app">
    </div>


</body>
</html>
