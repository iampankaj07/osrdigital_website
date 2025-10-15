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
    <title>Service Temporarily Unavailable - {{ $siteTitle }}</title>
    <meta name="title" content="Service Temporarily Unavailable - {{ $siteTitle }}">
    <meta name="description" content="We're temporarily performing maintenance. We'll be back online shortly. Thank you for your patience.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Service Temporarily Unavailable - {{ $siteTitle }}">
    <meta property="og:description" content="We're temporarily performing maintenance. We'll be back online shortly. Thank you for your patience.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Service Temporarily Unavailable - {{ $siteTitle }}">
    <meta property="twitter:description" content="We're temporarily performing maintenance. We'll be back online shortly. Thank you for your patience.">
    @if($logoUrl)
    <meta property="twitter:image" content="{{ url($logoUrl) }}">
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

    @vite(['resources/css/app.css'])

    <!-- Site Settings for JavaScript -->
    <script>
        window.siteSettings = @json(\App\Helpers\ThemeHelper::allForFrontend());
    </script>

    <style>
        .maintenance-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .gear-rotation {
            animation: rotate 3s linear infinite;
        }
        
        .gear-rotation-reverse {
            animation: rotate-reverse 2s linear infinite;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes rotate-reverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #EC681D 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .progress-bar {
            animation: progress 3s ease-in-out infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Logo -->
            <div class="mb-8 fade-in">
                <a href="/" class="inline-block">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteTitle }}" class="h-16 w-auto mx-auto">
                    @else
                        <div class="text-4xl font-bold text-brand-orange-500">{{ $siteTitle }}</div>
                    @endif
                </a>
            </div>

            <!-- Maintenance Content -->
            <div class="maintenance-animation">
                <!-- 503 Number with Gears -->
                <div class="mb-8 relative">
                    <div class="relative inline-block">
                        <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text">503</h1>
                        <!-- Gears -->
                        <div class="absolute -top-4 -right-4">
                            <i class="fas fa-cog text-4xl text-brand-orange-500 gear-rotation"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4">
                            <i class="fas fa-cog text-3xl text-brand-orange-400 gear-rotation-reverse"></i>
                        </div>
                        <div class="absolute top-1/2 -right-8">
                            <i class="fas fa-cog text-2xl text-brand-orange-300 gear-rotation"></i>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div class="mb-8 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        We're Temporarily Down
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
                        We're performing some maintenance to improve your experience. 
                        Our team is working hard to get everything back online as soon as possible.
                    </p>
                    
                    <!-- Progress Bar -->
                    <div class="w-full max-w-md mx-auto bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
                        <div class="bg-gradient-to-r from-brand-orange-500 to-brand-orange-600 h-2 rounded-full progress-bar"></div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-tools mr-2"></i>
                        Maintenance in progress...
                    </p>
                </div>

                <!-- Status Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-8 fade-in">
                    <div class="flex items-center justify-center mb-6">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">Maintenance Mode</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                        <div class="p-4">
                            <i class="fas fa-clock text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Estimated Time</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">15-30 minutes</p>
                        </div>
                        <div class="p-4">
                            <i class="fas fa-shield-alt text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Status</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">System Update</p>
                        </div>
                        <div class="p-4">
                            <i class="fas fa-users text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Team</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Working on it</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 fade-in">
                    <button onclick="location.reload()" class="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Try Again
                    </button>
                    <a href="mailto:{{ \App\Helpers\SettingsHelper::getContactEmail() }}" class="inline-flex items-center px-8 py-4 border-2 border-brand-orange-500 text-brand-orange-500 hover:bg-brand-orange-500 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Support
                    </a>
                </div>

                <!-- Social Media -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Stay Updated
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Follow us for real-time updates on our maintenance progress:
                    </p>
                    <div class="flex justify-center space-x-4">
                        @php
                            $socialSettings = \App\Helpers\SettingsHelper::getSocialMediaSettings();
                        @endphp
                        
                        @if(!empty($socialSettings['twitter_url']))
                        <a href="{{ $socialSettings['twitter_url'] }}" target="_blank" class="p-3 rounded-full bg-blue-500 hover:bg-blue-600 text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        
                        @if(!empty($socialSettings['facebook_url']))
                        <a href="{{ $socialSettings['facebook_url'] }}" target="_blank" class="p-3 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        
                        @if(!empty($socialSettings['linkedin_url']))
                        <a href="{{ $socialSettings['linkedin_url'] }}" target="_blank" class="p-3 rounded-full bg-blue-700 hover:bg-blue-800 text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center fade-in">
                    <p class="text-gray-500 dark:text-gray-400">
                        Thank you for your patience. We'll be back online shortly!
                    </p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">
                        Last updated: {{ now()->format('M d, Y \a\t g:i A T') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle -->
    <div class="fixed bottom-6 right-6">
        <button id="theme-toggle" class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
            <i class="fas fa-sun dark:hidden text-yellow-500"></i>
            <i class="fas fa-moon hidden dark:block text-blue-400"></i>
        </button>
    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);

        // Theme toggle functionality
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Initialize theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
