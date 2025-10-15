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
    <title>Under Maintenance - {{ $siteTitle }}</title>
    <meta name="title" content="Under Maintenance - {{ $siteTitle }}">
    <meta name="description" content="We're currently performing scheduled maintenance to improve your experience. We'll be back online shortly.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Under Maintenance - {{ $siteTitle }}">
    <meta property="og:description" content="We're currently performing scheduled maintenance to improve your experience. We'll be back online shortly.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Under Maintenance - {{ $siteTitle }}">
    <meta property="twitter:description" content="We're currently performing scheduled maintenance to improve your experience. We'll be back online shortly.">
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
            animation: maintenancePulse 3s ease-in-out infinite;
        }
        
        .gear-rotation {
            animation: rotate 4s linear infinite;
        }
        
        .gear-rotation-reverse {
            animation: rotate-reverse 3s linear infinite;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        .progress-animation {
            animation: progress 2s ease-in-out infinite;
        }
        
        @keyframes maintenancePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
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
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 75%; }
            100% { width: 100%; }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #EC681D 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .maintenance-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .dark .maintenance-bg {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }
    </style>
</head>
<body class="min-h-screen maintenance-bg">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Logo -->
            <div class="mb-8 fade-in">
                <a href="/" class="inline-block">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteTitle }}" class="h-20 w-auto mx-auto">
                    @else
                        <div class="text-5xl font-bold text-brand-orange-500">{{ $siteTitle }}</div>
                    @endif
                </a>
            </div>

            <!-- Maintenance Content -->
            <div class="maintenance-animation">
                <!-- Maintenance Icon with Gears -->
                <div class="mb-8 relative">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 bg-gradient-to-br from-brand-orange-500 to-brand-orange-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                            <i class="fas fa-tools text-5xl text-white"></i>
                        </div>
                        <!-- Gears around the main icon -->
                        <div class="absolute -top-2 -right-2">
                            <i class="fas fa-cog text-3xl text-brand-orange-400 gear-rotation"></i>
                        </div>
                        <div class="absolute -bottom-2 -left-2">
                            <i class="fas fa-cog text-2xl text-brand-orange-300 gear-rotation-reverse"></i>
                        </div>
                        <div class="absolute top-1/2 -right-6">
                            <i class="fas fa-cog text-xl text-brand-orange-200 gear-rotation"></i>
                        </div>
                        <div class="absolute top-1/2 -left-6">
                            <i class="fas fa-cog text-xl text-brand-orange-200 gear-rotation-reverse"></i>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Message -->
                <div class="mb-8 fade-in">
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        We're Under Maintenance
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                        We're currently performing scheduled maintenance to improve your experience. 
                        Our team is working hard to bring you an even better platform.
                    </p>
                    
                    <!-- Progress Bar -->
                    <div class="w-full max-w-md mx-auto bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-4">
                        <div class="bg-gradient-to-r from-brand-orange-500 to-brand-orange-600 h-3 rounded-full progress-animation"></div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-tools mr-2"></i>
                        Maintenance in progress...
                    </p>
                </div>

                <!-- Status Information -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-2xl mb-8 fade-in">
                    <div class="flex items-center justify-center mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full animate-pulse"></div>
                            <span class="text-xl font-semibold text-gray-900 dark:text-white">Scheduled Maintenance</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="p-4 text-center">
                            <i class="fas fa-clock text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Duration</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">2-4 hours</p>
                        </div>
                        <div class="p-4 text-center">
                            <i class="fas fa-calendar text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Started</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('M d, Y g:i A') }}</p>
                        </div>
                        <div class="p-4 text-center">
                            <i class="fas fa-shield-alt text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Type</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">System Update</p>
                        </div>
                        <div class="p-4 text-center">
                            <i class="fas fa-users text-3xl text-brand-orange-500 mb-3"></i>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Team</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Working on it</p>
                        </div>
                    </div>
                </div>

                <!-- What's Being Updated -->
                <div class="bg-gradient-to-r from-brand-orange-50 to-brand-orange-100 dark:from-brand-orange-900/20 dark:to-brand-orange-800/20 rounded-3xl p-8 shadow-2xl mb-8 fade-in">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-rocket mr-2"></i>
                        What We're Working On
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Performance Improvements</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Faster loading times and better responsiveness</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Security Updates</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Enhanced security measures and data protection</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">New Features</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Exciting new functionality and improvements</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Bug Fixes</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Resolving known issues and improving stability</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 fade-in">
                    <button onclick="location.reload()" class="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Check Status
                    </button>
                    <a href="mailto:{{ \App\Helpers\SettingsHelper::getContactEmail() }}" class="inline-flex items-center px-8 py-4 border-2 border-brand-orange-500 text-brand-orange-500 hover:bg-brand-orange-500 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Support
                    </a>
                </div>

                <!-- Social Media Updates -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-2xl fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-bullhorn mr-2"></i>
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
        // Auto-refresh every 60 seconds
        setTimeout(function() {
            location.reload();
        }, 60000);

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
