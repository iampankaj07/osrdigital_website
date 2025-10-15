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
    <title>Access Denied - {{ $siteTitle }}</title>
    <meta name="title" content="Access Denied - {{ $siteTitle }}">
    <meta name="description" content="You don't have permission to access this resource. Please contact us if you believe this is an error.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Access Denied - {{ $siteTitle }}">
    <meta property="og:description" content="You don't have permission to access this resource. Please contact us if you believe this is an error.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Access Denied - {{ $siteTitle }}">
    <meta property="twitter:description" content="You don't have permission to access this resource. Please contact us if you believe this is an error.">
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
        .lock-animation {
            animation: lockBounce 2s ease-in-out infinite;
        }
        
        .shield-animation {
            animation: shieldPulse 3s ease-in-out infinite;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes lockBounce {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(-5deg); }
            50% { transform: translateY(-5px) rotate(0deg); }
            75% { transform: translateY(-15px) rotate(5deg); }
        }
        
        @keyframes shieldPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
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

            <!-- Error Content -->
            <div class="lock-animation">
                <!-- 403 Number with Lock -->
                <div class="mb-8 relative">
                    <div class="relative inline-block">
                        <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text">403</h1>
                        <!-- Lock Icon -->
                        <div class="absolute -top-4 -right-4">
                            <i class="fas fa-lock text-4xl text-brand-orange-500 lock-animation"></i>
                        </div>
                        <!-- Shield Icon -->
                        <div class="absolute -bottom-4 -left-4">
                            <i class="fas fa-shield-alt text-3xl text-brand-orange-400 shield-animation"></i>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div class="mb-8 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Access Denied
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
                        You don't have permission to access this resource. This could be due to insufficient privileges 
                        or the content being restricted to certain users only.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 fade-in">
                    <a href="/" class="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <i class="fas fa-home mr-2"></i>
                        Go Home
                    </a>
                    <button onclick="history.back()" class="inline-flex items-center px-8 py-4 border-2 border-brand-orange-500 text-brand-orange-500 hover:bg-brand-orange-500 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Go Back
                    </button>
                    <a href="/contact" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Support
                    </a>
                </div>

                <!-- Access Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-8 fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-info-circle mr-2"></i>
                        Why am I seeing this?
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left">
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                <i class="fas fa-user-lock text-brand-orange-500 mr-2"></i>
                                Authentication Required
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                This content requires you to be logged in with appropriate permissions.
                            </p>
                        </div>
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                <i class="fas fa-ban text-brand-orange-500 mr-2"></i>
                                Restricted Content
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                This resource is restricted to specific users or user groups.
                            </p>
                        </div>
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                <i class="fas fa-clock text-brand-orange-500 mr-2"></i>
                                Session Expired
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Your session may have expired. Please log in again.
                            </p>
                        </div>
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                <i class="fas fa-globe text-brand-orange-500 mr-2"></i>
                                Geographic Restriction
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                This content may not be available in your region.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Solutions -->
                <div class="bg-gradient-to-r from-brand-orange-50 to-brand-orange-100 dark:from-brand-orange-900/20 dark:to-brand-orange-800/20 rounded-2xl p-8 shadow-lg fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-lightbulb mr-2"></i>
                        What can you do?
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-brand-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-sign-in-alt text-2xl text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Log In</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sign in with your account to access this content</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-brand-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-2xl text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Request Access</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Contact us to request access to this resource</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-brand-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-home text-2xl text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Browse Public Content</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Explore our public content and resources</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center fade-in">
                    <p class="text-gray-500 dark:text-gray-400">
                        If you believe this is an error, please 
                        <a href="/contact" class="text-brand-orange-500 hover:text-brand-orange-600 font-medium">contact our support team</a> 
                        with details about what you were trying to access.
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

    <script>
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
