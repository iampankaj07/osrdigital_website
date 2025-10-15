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
    <title>Server Error - {{ $siteTitle }}</title>
    <meta name="title" content="Server Error - {{ $siteTitle }}">
    <meta name="description" content="We encountered an unexpected error. Our team has been notified and is working to fix the issue.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Server Error - {{ $siteTitle }}">
    <meta property="og:description" content="We encountered an unexpected error. Our team has been notified and is working to fix the issue.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Server Error - {{ $siteTitle }}">
    <meta property="twitter:description" content="We encountered an unexpected error. Our team has been notified and is working to fix the issue.">
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
        .error-shake {
            animation: shake 0.5s ease-in-out;
        }
        
        .error-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(236, 104, 29, 0.3); }
            to { box-shadow: 0 0 30px rgba(236, 104, 29, 0.6); }
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
        
        .error-code {
            font-family: 'Courier New', monospace;
            background: rgba(0, 0, 0, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
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
            <div class="error-shake">
                <!-- 500 Number -->
                <div class="mb-8">
                    <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text error-glow">500</h1>
                </div>

                <!-- Error Message -->
                <div class="mb-8 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Oops! Something Went Wrong
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
                        We encountered an unexpected error while processing your request. 
                        Don't worry, our technical team has been automatically notified and is working to fix this issue.
                    </p>
                    
                    <!-- Error Details (only in debug mode) -->
                    @if(config('app.debug') && isset($exception))
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6 text-left">
                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">
                            <i class="fas fa-bug mr-2"></i>
                            Debug Information
                        </h3>
                        <div class="text-xs text-red-700 dark:text-red-300 font-mono">
                            <div class="mb-2">
                                <strong>Error:</strong> {{ $exception->getMessage() }}
                            </div>
                            <div class="mb-2">
                                <strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}
                            </div>
                            <div>
                                <strong>Trace:</strong>
                                <pre class="mt-2 whitespace-pre-wrap">{{ $exception->getTraceAsString() }}</pre>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 fade-in">
                    <button onclick="location.reload()" class="inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Try Again
                    </button>
                    <a href="/" class="inline-flex items-center px-8 py-4 border-2 border-brand-orange-500 text-brand-orange-500 hover:bg-brand-orange-500 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Go Home
                    </a>
                    <button onclick="history.back()" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Go Back
                    </button>
                </div>

                <!-- Help Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-8 fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        What can you do?
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-sync-alt text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Refresh the Page</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sometimes a simple refresh can resolve the issue</p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Wait a Moment</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Our team is working to fix this issue</p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Contact Support</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">If the problem persists, let us know</p>
                        </div>
                    </div>
                </div>

                <!-- Technical Information -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 shadow-lg fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-info-circle mr-2"></i>
                        Technical Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Error Code:</span>
                            <span class="error-code font-mono">500</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Timestamp:</span>
                            <span class="font-mono">{{ now()->format('Y-m-d H:i:s T') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Request ID:</span>
                            <span class="font-mono">{{ request()->header('X-Request-ID', 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">User Agent:</span>
                            <span class="font-mono text-xs truncate">{{ request()->header('User-Agent', 'N/A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center fade-in">
                    <p class="text-gray-500 dark:text-gray-400">
                        If this error continues to occur, please 
                        <a href="mailto:{{ \App\Helpers\SettingsHelper::getContactEmail() }}" class="text-brand-orange-500 hover:text-brand-orange-600 font-medium">contact our support team</a> 
                        with the error code above.
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

        // Auto-refresh after 30 seconds if user hasn't interacted
        let userInteracted = false;
        document.addEventListener('click', () => userInteracted = true);
        document.addEventListener('keypress', () => userInteracted = true);
        
        setTimeout(() => {
            if (!userInteracted) {
                location.reload();
            }
        }, 30000);
    </script>
</body>
</html>
