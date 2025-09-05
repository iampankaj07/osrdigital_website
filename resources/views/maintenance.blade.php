<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance - {{ $settings['site_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <x-logo type="auto" class="mx-auto" />

                <h1 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    We'll be back soon!
                </h1>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ $settings['site_name'] }} is currently undergoing scheduled maintenance.
                </p>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.963-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>

                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        Maintenance in Progress
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        We are currently performing scheduled maintenance to improve our services.
                        We should be back online shortly. Thank you for your patience!
                    </p>
                </div>

                @if($settings['contact']['email'])
                <div class="mt-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            For urgent matters, please contact us at:
                        </p>
                        <a href="mailto:{{ $settings['contact']['email'] }}"
                           class="mt-1 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                            {{ $settings['contact']['email'] }}
                        </a>
                    </div>
                </div>
                @endif

                @if($settings['contact']['phone'])
                <div class="mt-2">
                    <div class="text-center">
                        <a href="tel:{{ $settings['contact']['phone'] }}"
                           class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                            {{ $settings['contact']['phone'] }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 dark:text-gray-600">
                &copy; {{ date('Y') }} {{ $settings['site_name'] }}. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Theme switcher (if enabled) -->
    <div class="fixed top-4 right-4">
        <x-theme-switcher />
    </div>

    <script>
        // Auto-refresh page every 30 seconds
        setTimeout(function() {
            window.location.reload();
        }, 30000);
    </script>
</body>
</html>
