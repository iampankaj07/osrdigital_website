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
    <title>Page Not Found - {{ $siteTitle }}</title>
    <meta name="title" content="Page Not Found - {{ $siteTitle }}">
    <meta name="description" content="The page you're looking for doesn't exist. Return to our homepage to explore our digital content distribution services.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Page Not Found - {{ $siteTitle }}">
    <meta property="og:description" content="The page you're looking for doesn't exist. Return to our homepage to explore our digital content distribution services.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Page Not Found - {{ $siteTitle }}">
    <meta property="twitter:description" content="The page you're looking for doesn't exist. Return to our homepage to explore our digital content distribution services.">
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
        .error-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .error-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
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
            <div class="mb-8">
                <a href="/" class="inline-block">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteTitle }}" class="h-16 w-auto mx-auto">
                    @else
                        <div class="text-4xl font-bold text-brand-orange-500">{{ $siteTitle }}</div>
                    @endif
                </a>
            </div>

            <!-- Error Content -->
            <div class="error-animation">
                <!-- 404 Number -->
                <div class="mb-8">
                    <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text error-bounce">404</h1>
                </div>

                <!-- Error Message -->
                <div class="mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Oops! Page Not Found
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        The page you're looking for seems to have vanished into the digital void. 
                        Don't worry, even the best content distributors sometimes lose a page or two!
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="/" class="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <i class="fas fa-home mr-2"></i>
                        Go Home
                    </a>
                    <a href="/portfolio" class="inline-flex items-center px-8 py-4 border-2 border-brand-orange-500 text-brand-orange-500 hover:bg-brand-orange-500 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-film mr-2"></i>
                        View Portfolio
                    </a>
                    <button onclick="history.back()" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Go Back
                    </button>
                </div>

                <!-- Helpful Links -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Maybe you were looking for:
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="/about" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-info-circle text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">About Us</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Learn about our mission</div>
                            </div>
                        </a>
                        <a href="/portfolio" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-film text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">Portfolio</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">View our content</div>
                            </div>
                        </a>
                        <a href="/contact" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-envelope text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">Contact</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Get in touch</div>
                            </div>
                        </a>
                        <a href="/team" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-users text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">Team</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Meet our team</div>
                            </div>
                        </a>
                        <a href="/news" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-newspaper text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">News</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Latest updates</div>
                            </div>
                        </a>
                        <a href="/partners" class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-brand-orange-500 hover:bg-brand-orange-50 dark:hover:bg-brand-orange-900/20 transition-all duration-300 group">
                            <i class="fas fa-handshake text-brand-orange-500 mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                            <div class="text-left">
                                <div class="font-medium text-gray-900 dark:text-white">Partners</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Our partners</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400">
                        Still can't find what you're looking for? 
                        <a href="/contact" class="text-brand-orange-500 hover:text-brand-orange-600 font-medium">Contact us</a> 
                        and we'll help you out!
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
