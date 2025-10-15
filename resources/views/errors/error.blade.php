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
        $errorCode = $exception->getStatusCode() ?? 500;
    @endphp

    <!-- Primary Meta Tags -->
    <title>Error {{ $errorCode }} - {{ $siteTitle }}</title>
    <meta name="title" content="Error {{ $errorCode }} - {{ $siteTitle }}">
    <meta name="description" content="An error occurred while processing your request. Please try again or contact support if the problem persists.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Error {{ $errorCode }} - {{ $siteTitle }}">
    <meta property="og:description" content="An error occurred while processing your request. Please try again or contact support if the problem persists.">
    @if($logoUrl)
    <meta property="og:image" content="{{ url($logoUrl) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Error {{ $errorCode }} - {{ $siteTitle }}">
    <meta property="twitter:description" content="An error occurred while processing your request. Please try again or contact support if the problem persists.">
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
        .error-pulse {
            animation: errorPulse 2s ease-in-out infinite;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes errorPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
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
            <div class="error-pulse">
                <!-- Error Number -->
                <div class="mb-8">
                    <h1 class="text-9xl sm:text-[12rem] font-bold gradient-text">{{ $errorCode }}</h1>
                </div>

                <!-- Error Message -->
                <div class="mb-8 fade-in">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        @switch($errorCode)
                            @case(400)
                                Bad Request
                                @break
                            @case(401)
                                Unauthorized
                                @break
                            @case(402)
                                Payment Required
                                @break
                            @case(404)
                                Page Not Found
                                @break
                            @case(405)
                                Method Not Allowed
                                @break
                            @case(406)
                                Not Acceptable
                                @break
                            @case(408)
                                Request Timeout
                                @break
                            @case(409)
                                Conflict
                                @break
                            @case(410)
                                Gone
                                @break
                            @case(411)
                                Length Required
                                @break
                            @case(412)
                                Precondition Failed
                                @break
                            @case(413)
                                Payload Too Large
                                @break
                            @case(414)
                                URI Too Long
                                @break
                            @case(415)
                                Unsupported Media Type
                                @break
                            @case(416)
                                Range Not Satisfiable
                                @break
                            @case(417)
                                Expectation Failed
                                @break
                            @case(418)
                                I'm a teapot
                                @break
                            @case(422)
                                Unprocessable Entity
                                @break
                            @case(423)
                                Locked
                                @break
                            @case(424)
                                Failed Dependency
                                @break
                            @case(425)
                                Too Early
                                @break
                            @case(426)
                                Upgrade Required
                                @break
                            @case(428)
                                Precondition Required
                                @break
                            @case(429)
                                Too Many Requests
                                @break
                            @case(431)
                                Request Header Fields Too Large
                                @break
                            @case(451)
                                Unavailable For Legal Reasons
                                @break
                            @case(500)
                                Internal Server Error
                                @break
                            @case(501)
                                Not Implemented
                                @break
                            @case(502)
                                Bad Gateway
                                @break
                            @case(503)
                                Service Unavailable
                                @break
                            @case(504)
                                Gateway Timeout
                                @break
                            @case(505)
                                HTTP Version Not Supported
                                @break
                            @case(506)
                                Variant Also Negotiates
                                @break
                            @case(507)
                                Insufficient Storage
                                @break
                            @case(508)
                                Loop Detected
                                @break
                            @case(510)
                                Not Extended
                                @break
                            @case(511)
                                Network Authentication Required
                                @break
                            @default
                                An Error Occurred
                        @endswitch
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-6">
                        @switch($errorCode)
                            @case(400)
                                The request was invalid or cannot be served. Please check your request and try again.
                                @break
                            @case(401)
                                You need to be authenticated to access this resource. Please log in and try again.
                                @break
                            @case(402)
                                Payment is required to access this resource.
                                @break
                            @case(404)
                                The page you're looking for doesn't exist. It may have been moved or deleted.
                                @break
                            @case(405)
                                The request method is not allowed for this resource.
                                @break
                            @case(406)
                                The server cannot produce a response matching the list of acceptable values.
                                @break
                            @case(408)
                                The request took too long to process. Please try again.
                                @break
                            @case(409)
                                The request conflicts with the current state of the resource.
                                @break
                            @case(410)
                                The requested resource is no longer available and will not be available again.
                                @break
                            @case(411)
                                The request requires a valid Content-Length header.
                                @break
                            @case(412)
                                One or more preconditions in the request header fields evaluated to false.
                                @break
                            @case(413)
                                The request payload is too large.
                                @break
                            @case(414)
                                The URI provided was too long for the server to process.
                                @break
                            @case(415)
                                The media format of the requested data is not supported by the server.
                                @break
                            @case(416)
                                The range specified in the Range header field cannot be fulfilled.
                                @break
                            @case(417)
                                The expectation given in the Expect header field cannot be met.
                                @break
                            @case(418)
                                I'm a teapot! (This is a joke response from RFC 2324)
                                @break
                            @case(422)
                                The request was well-formed but contains semantic errors.
                                @break
                            @case(423)
                                The resource that is being accessed is locked.
                                @break
                            @case(424)
                                The request failed due to failure of a previous request.
                                @break
                            @case(425)
                                The server is unwilling to risk processing a request that might be replayed.
                                @break
                            @case(426)
                                The server refuses to perform the request using the current protocol.
                                @break
                            @case(428)
                                The origin server requires the request to be conditional.
                                @break
                            @case(429)
                                Too many requests have been sent in a given amount of time.
                                @break
                            @case(431)
                                The server is unwilling to process the request due to header fields being too large.
                                @break
                            @case(451)
                                The resource is unavailable for legal reasons.
                                @break
                            @case(500)
                                An internal server error occurred. Our team has been notified.
                                @break
                            @case(501)
                                The server does not support the functionality required to fulfill the request.
                                @break
                            @case(502)
                                The server received an invalid response from an upstream server.
                                @break
                            @case(503)
                                The server is temporarily unable to handle the request.
                                @break
                            @case(504)
                                The server did not receive a timely response from an upstream server.
                                @break
                            @case(505)
                                The server does not support the HTTP protocol version used in the request.
                                @break
                            @case(506)
                                The server has an internal configuration error.
                                @break
                            @case(507)
                                The server is unable to store the representation needed to complete the request.
                                @break
                            @case(508)
                                The server detected an infinite loop while processing the request.
                                @break
                            @case(510)
                                Further extensions to the request are required for the server to fulfill it.
                                @break
                            @case(511)
                                The client needs to authenticate to gain network access.
                                @break
                            @default
                                An unexpected error occurred. Please try again or contact support if the problem persists.
                        @endswitch
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
                    <button onclick="location.reload()" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Try Again
                    </button>
                </div>

                <!-- Error Details (only in debug mode) -->
                @if(config('app.debug') && isset($exception))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mb-8 fade-in">
                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-4">
                        <i class="fas fa-bug mr-2"></i>
                        Debug Information
                    </h3>
                    <div class="text-sm text-red-700 dark:text-red-300 font-mono text-left">
                        <div class="mb-2">
                            <strong>Error:</strong> {{ $exception->getMessage() }}
                        </div>
                        <div class="mb-2">
                            <strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}
                        </div>
                        <div class="mb-2">
                            <strong>Code:</strong> {{ $errorCode }}
                        </div>
                        <div>
                            <strong>Trace:</strong>
                            <pre class="mt-2 whitespace-pre-wrap text-xs">{{ $exception->getTraceAsString() }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Help Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg fade-in">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-question-circle mr-2"></i>
                        Need Help?
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-envelope text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Contact Support</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <a href="/contact" class="text-brand-orange-500 hover:text-brand-orange-600">Get in touch</a> with our support team
                            </p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Documentation</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Check our <a href="/" class="text-brand-orange-500 hover:text-brand-orange-600">help center</a> for solutions
                            </p>
                        </div>
                        <div class="text-center p-4">
                            <div class="w-16 h-16 bg-brand-orange-100 dark:bg-brand-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-refresh text-2xl text-brand-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Try Again</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Sometimes a simple refresh can resolve the issue
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center fade-in">
                    <p class="text-gray-500 dark:text-gray-400">
                        If this error persists, please 
                        <a href="/contact" class="text-brand-orange-500 hover:text-brand-orange-600 font-medium">contact our support team</a> 
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
    </script>
</body>
</html>
