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
    <title>Too Many Requests - {{ $siteTitle }}</title>
    <meta name="title" content="Too Many Requests - {{ $siteTitle }}">
    <meta name="description" content="You've made too many requests. Please wait a moment before trying again.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Too Many Requests - {{ $siteTitle }}">
    <meta property="og:description" content="You've made too many requests. Please wait a moment before trying again.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Too Many Requests - {{ $siteTitle }}">
    <meta property="twitter:description" content="You've made too many requests. Please wait a moment before trying again.">
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
        .timer-animation {
            animation: timerPulse 2s ease-in-out infinite;
        }
        
        .countdown-animation {
            animation: countdown 1s ease-in-out;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes timerPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes countdown {
            0% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
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
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform-origin: 50% 50%;
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
            <div class="timer-animation">
                <!-- 429 Number with Timer -->
                <div class="mb-8 relative">
                    <div class="relative inline-block">
                        <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text">429</h1>
                        <!-- Timer Icon -->
                        <div class="absolute -top-4 -right-4">
                            <i class="fas fa-clock text-4xl text-brand-orange-500 timer-animation"></i>
                        </div>
                        <!-- Speed Icon -->
                        <div class="absolute -bottom-4 -left-4">
                            <i class="fas fa-tachometer-alt text-3xl text-brand-orange-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div class="mb-8 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Too Many Requests
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
                        You've made too many requests in a short period of time. This helps us maintain 
                        optimal performance for all users. Please wait a moment before trying again.
                    </p>
                </div>

                <!-- Countdown Timer -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-8 fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-hourglass-half mr-2"></i>
                        Please Wait
                    </h3>
                    
                    <div class="flex items-center justify-center mb-6">
                        <!-- Circular Progress -->
                        <div class="relative w-32 h-32">
                            <svg class="progress-ring w-32 h-32">
                                <circle
                                    class="progress-ring-circle stroke-brand-orange-500"
                                    stroke-width="8"
                                    fill="transparent"
                                    r="56"
                                    cx="64"
                                    cy="64"
                                    stroke-dasharray="351.86"
                                    stroke-dashoffset="351.86"
                                    id="progress-circle"
                                />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div id="countdown" class="text-3xl font-bold text-brand-orange-500">60</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">seconds</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-300">
                        You can try again in <span id="countdown-text" class="font-semibold text-brand-orange-500">60 seconds</span>
                    </p>
                </div>

                <!-- Rate Limit Information -->
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl p-8 shadow-lg mb-8 fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-info-circle mr-2"></i>
                        Rate Limit Information
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Rate Limit Exceeded</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                You've exceeded the maximum number of requests per minute
                            </p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-2xl text-white"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Auto Reset</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Your rate limit will reset automatically after the countdown
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 fade-in">
                    <button onclick="location.reload()" id="retry-btn" disabled class="inline-flex items-center px-8 py-4 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-semibold rounded-lg cursor-not-allowed transition-all duration-300">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Try Again (<span id="retry-countdown">60</span>s)
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

                <!-- Tips -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Tips to Avoid Rate Limiting
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-left">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <div>
                                <strong>Wait Between Requests:</strong> Allow a few seconds between page loads
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <div>
                                <strong>Use Navigation:</strong> Use the site's navigation instead of refreshing
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <div>
                                <strong>Avoid Rapid Clicking:</strong> Don't click buttons rapidly
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <div>
                                <strong>Clear Cache:</strong> Clear your browser cache if issues persist
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center fade-in">
                    <p class="text-gray-500 dark:text-gray-400">
                        If you continue to experience issues, please 
                        <a href="/contact" class="text-brand-orange-500 hover:text-brand-orange-600 font-medium">contact our support team</a>.
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
        // Countdown timer
        let timeLeft = 60;
        const countdownElement = document.getElementById('countdown');
        const countdownTextElement = document.getElementById('countdown-text');
        const retryBtn = document.getElementById('retry-btn');
        const retryCountdownElement = document.getElementById('retry-countdown');
        const progressCircle = document.getElementById('progress-circle');
        
        const circumference = 2 * Math.PI * 56; // radius = 56
        progressCircle.style.strokeDasharray = circumference;
        progressCircle.style.strokeDashoffset = circumference;
        
        const timer = setInterval(() => {
            timeLeft--;
            
            // Update countdown display
            countdownElement.textContent = timeLeft;
            countdownTextElement.textContent = timeLeft + ' seconds';
            retryCountdownElement.textContent = timeLeft;
            
            // Update progress circle
            const offset = circumference - (timeLeft / 60) * circumference;
            progressCircle.style.strokeDashoffset = offset;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                retryBtn.disabled = false;
                retryBtn.className = 'inline-flex items-center px-8 py-4 bg-brand-orange-500 hover:bg-brand-orange-600 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-1';
                retryBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Try Again';
                countdownElement.textContent = '0';
                countdownTextElement.textContent = 'You can try again now!';
            }
        }, 1000);

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
