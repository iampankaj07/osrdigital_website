<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - OSR Digital</title>
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Monda:wght@400;700&display=swap" rel="stylesheet"></noscript>
    
    <!-- Load Vite-built CSS -->
    @vite(['resources/css/app.css', 'resources/css/skeleton.css'])
    
    <!-- Load CSS in proper order -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <!-- Quill.js Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="{{ asset('js/quill-config.js') }}"></script>
    <style>
        /* Critical CSS to prevent layout shifts */
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Monda', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f9fafb;
            line-height: 1.5;
        }
        
        .min-h-screen {
            min-height: 100vh;
        }
        
        .flex {
            display: flex;
        }
        
        .w-64 {
            width: 16rem;
        }
        
        .bg-white {
            background-color: #ffffff;
        }
        
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        
        .pro-badge {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }
        .nav-item-active {
            background: rgba(139, 92, 246, 0.2);
            border-left: 3px solid #a78bfa;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }
        body {
            font-family: 'Monda', sans-serif;
        }
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 transparent;
        }
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 3px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
        .sticky-header {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
            transition: all 0.2s ease-in-out;
        }
        @supports not (backdrop-filter: blur(8px)) {
            .sticky-header {
                background-color: rgba(255, 255, 255, 0.98);
            }
        }
        .sticky-header:hover {
background-color: rgba(255, 255, 255, 0.98);
        }
        
        /* FilePond customizations */
        .filepond--root {
            margin-bottom: 0;
        }
        
        .filepond--panel-root {
            background-color: transparent;
            border: none;
        }
        
        .filepond--drop-label {
            color: #6b7280;
        }
        
        .filepond--credits {
            display: none;
        }
        
        /* Loading state to prevent glitches */
        .loading {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .loaded {
            opacity: 1;
        }
        
        /* Prevent FOUC */
        .no-js .loading {
            opacity: 1;
        }
        
        /* Quill.js Editor Styling */
        .ql-editor {
            min-height: 200px;
            font-family: -apple-system, BlinkMacSystemFont, 'San Francisco', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .ql-container {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            font-family: -apple-system, BlinkMacSystemFont, 'San Francisco', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        
        .ql-toolbar {
            border: 1px solid #d1d5db !important;
            border-bottom: none !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
            background-color: #f9fafb !important;
        }
        
        .ql-container.ql-snow {
            border-radius: 0 0 0.5rem 0.5rem !important;
        }
        
        /* Focus state */
        .ql-container:focus-within {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
        }
        
        /* Custom toolbar button styling */
        .ql-toolbar .ql-stroke {
            stroke: #6b7280;
        }
        
        .ql-toolbar .ql-fill {
            fill: #6b7280;
        }
        
        .ql-toolbar button:hover .ql-stroke {
            stroke: #8b5cf6;
        }
        
        .ql-toolbar button:hover .ql-fill {
            fill: #8b5cf6;
        }
        
        .ql-toolbar button.ql-active .ql-stroke {
            stroke: #8b5cf6;
        }
        
        .ql-toolbar button.ql-active .ql-fill {
            fill: #8b5cf6;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex loading" id="main-container">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 border-r border-gray-700 sidebar-shadow sticky top-0 h-screen overflow-y-auto flex flex-col sidebar z-10">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-700 flex-shrink-0">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-video text-white text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">OSR Digital</h1>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 flex-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <!-- Content Section -->
                <div class="px-6 py-2 mt-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">CONTENT</h3>
                </div>
                
                
                <a href="{{ route('admin.hero-sections.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.hero-sections*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-star w-5 h-5 mr-3"></i>
                    Hero Sections
                </a>
                
                <a href="{{ route('admin.associates.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.associates*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-handshake w-5 h-5 mr-3"></i>
                    Associates
                </a>
                
                <a href="{{ route('admin.distribution-services.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.distribution-services*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-truck w-5 h-5 mr-3"></i>
                    Distribution Services
                </a>
                
                <a href="{{ route('admin.global-impact.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.global-impact*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Global Impact
                </a>
                      <!-- Divider -->
             <div class="px-6 py-2">
                <div class="border-t border-gray-700"></div>
            </div>
            <div class="px-6 py-2 mt-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">About Us</h3>
            </div>
                <a href="{{ route('admin.mission-vision.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.mission-vision*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-bullseye w-5 h-5 mr-3"></i>
                    Mission & Vision
                </a>
                
                <a href="{{ route('admin.core-values.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.core-values*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-heart w-5 h-5 mr-3"></i>
                    Core Values
                </a>
                
                <a href="{{ route('admin.services.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.services*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                    Services
                </a>
                          <!-- Divider -->
             <div class="px-6 py-2">
                <div class="border-t border-gray-700"></div>
            </div>
            <div class="px-6 py-2 mt-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Our Partners</h3>
            </div>
                <a href="{{ route('admin.trusted-partners.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.trusted-partners*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-handshake w-5 h-5 mr-3"></i>
                    Trusted Partners
                </a>
                
                <a href="{{ route('admin.partnership-benefits.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.partnership-benefits*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-gift w-5 h-5 mr-3"></i>
                    Partnership Benefits
                </a>
                                  <!-- Divider -->
             <div class="px-6 py-2">
                <div class="border-t border-gray-700"></div>
            </div>
            <div class="px-6 py-2 mt-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Our Teams</h3>
            </div>
                <a href="{{ route('admin.team-members.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.team-members*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    Team Members
                </a>
                
                <a href="{{ route('admin.team-values.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.team-values*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-heart w-5 h-5 mr-3"></i>
                    Team Values
                </a>
                
             <!-- Divider -->
             <div class="px-6 py-2">
                <div class="border-t border-gray-700"></div>
            </div>
                <div class="px-6 py-2 mt-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Film</h3>
                </div>
                <a href="{{ route('admin.film-portfolios.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.film-portfolios*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-film w-5 h-5 mr-3"></i>
                    Film Portfolios
                </a>
          
                <a href="{{ route('admin.film-categories.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.film-categories*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-tags w-5 h-5 mr-3"></i>
                    Film Categories
                </a>

                      <!-- Divider -->
                      <div class="px-6 py-2">
                        <div class="border-t border-gray-700"></div>
                    </div>

                    <div class="px-6 py-2 mt-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Testimonials</h3>
                    </div>
                    <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.testimonials*') ? 'nav-item-active text-purple-400' : '' }}">
                        <i class="fas fa-quote-left w-5 h-5 mr-3"></i>
                        Testimonials
                    </a>
                            <!-- Divider -->
                            <div class="px-6 py-2">
                                <div class="border-t border-gray-700"></div>
                            </div>
                                     <!-- System Section -->
                <div class="px-6 py-2 mt-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">News & Categories</h3>
                </div>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.news*') ? 'nav-item-active text-purple-400' : '' }}">
                        <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                        News
                    </a>
                    
                    <a href="{{ route('admin.news-categories.index') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.news-categories*') ? 'nav-item-active text-purple-400' : '' }}">
                        <i class="fas fa-tags w-5 h-5 mr-3"></i>
                        News Categories
                    </a>
                       <!-- Divider -->
                       <div class="px-6 py-2">
                        <div class="border-t border-gray-700"></div>
                    </div>
               
                    <!-- System Section -->
                <div class="px-6 py-2 mt-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">SYSTEM</h3>
                </div>
                
                <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.settings*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    Settings
                </a>
                

                <a href="{{ route('admin.roles') }}" class="flex items-center px-6 py-3 text-white nav-item {{ request()->routeIs('admin.roles*') ? 'nav-item-active text-purple-400' : '' }}">
                    <i class="fas fa-users-cog w-5 h-5 mr-3"></i>
                    Roles & Permissions
                </a>
                
          
                
        
                
            
            </nav>

            <!-- User Section -->
            <div class="mt-auto p-6 border-t border-gray-700 flex-shrink-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-20 shadow-sm sticky-header">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 bg-gray-50 p-6 relative">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Load scripts in proper order with error handling -->
    <script>
        // Prevent layout shifts and glitches during loading
        document.addEventListener('DOMContentLoaded', function() {
            const mainContainer = document.getElementById('main-container');
            if (mainContainer) {
                mainContainer.classList.add('loaded');
            }
        });
        
        // Fallback for slow connections
        window.addEventListener('load', function() {
            const mainContainer = document.getElementById('main-container');
            if (mainContainer) {
                mainContainer.classList.add('loaded');
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js" defer></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js" defer></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js" defer></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js" defer></script>
    
    <!-- Load Vite-built JS -->
    @vite(['resources/js/app.js', 'resources/js/skeleton-loader.js'])
    
    @yield('scripts')
</body>
</html>