@extends('app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative py-16 md:py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-black">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-brand-orange-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-orange-500 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4 leading-tight">
                    {{ $page->title }}
                </h1>
                @if($page->excerpt)
                    <p class="text-xl text-gray-300 mb-6 leading-relaxed">
                        {{ $page->excerpt }}
                    </p>
                @endif
                <div class="flex items-center text-sm text-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Last updated: {{ $page->last_updated_at ? $page->last_updated_at->format('F j, Y') : 'Not specified' }}
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Table of Contents (if content has headings) -->
                <div class="mb-12 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-brand-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Table of Contents
                    </h2>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">Navigate through the sections of this document:</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                            <li><a href="#overview" class="text-brand-orange-600 hover:text-brand-orange-700 text-sm font-medium">Overview</a></li>
                            <li><a href="#content" class="text-brand-orange-600 hover:text-brand-orange-700 text-sm font-medium">Full Content</a></li>
                            <li><a href="#contact" class="text-brand-orange-600 hover:text-brand-orange-700 text-sm font-medium">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="prose prose-lg max-w-none mb-12">
                    <div id="content" class="text-gray-700 leading-relaxed space-y-6">
                        {!! $page->content !!}
                    </div>
                </div>

                <!-- Contact Section -->
                <div id="contact" class="mt-16 p-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Questions About This Policy?</h3>
                    <p class="text-gray-700 mb-6">
                        If you have any questions about this {{ strtolower($page->title) }}, please don't hesitate to contact us. We're here to help.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Email -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Email Us</h4>
                                <p class="text-gray-600 text-sm">hello@osrdigital.com</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Call Us</h4>
                                <p class="text-gray-600 text-sm">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <!-- Visit -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center bg-brand-orange-100 text-brand-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Visit Us</h4>
                                <p class="text-gray-600 text-sm">Los Angeles, CA</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="/contact" class="inline-flex items-center px-6 py-3 bg-brand-orange-600 text-white font-semibold rounded-lg hover:bg-brand-orange-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact Us
                        </a>
                    </div>
                </div>

                <!-- Related Links -->
                <div class="mt-16 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Related Legal Documents</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/privacy-policy" class="p-4 bg-white border border-gray-200 rounded-lg hover:border-brand-orange-600 hover:bg-gray-50 transition-all duration-200">
                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-brand-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Privacy Policy
                            </h4>
                            <p class="text-sm text-gray-600">Learn how we collect and use your data</p>
                        </a>

                        <a href="/terms-of-service" class="p-4 bg-white border border-gray-200 rounded-lg hover:border-brand-orange-600 hover:bg-gray-50 transition-all duration-200">
                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-brand-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
                                </svg>
                                Terms of Service
                            </h4>
                            <p class="text-sm text-gray-600">Read our terms and conditions</p>
                        </a>

                        <a href="/cookies-policy" class="p-4 bg-white border border-gray-200 rounded-lg hover:border-brand-orange-600 hover:bg-gray-50 transition-all duration-200">
                            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-brand-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v4h8v-4zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                                Cookie Policy
                            </h4>
                            <p class="text-sm text-gray-600">Understand our cookie usage</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to top button -->
    <section class="py-8 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex justify-between items-center max-w-4xl mx-auto">
                <div class="text-sm text-gray-600">
                    <p>Last updated: {{ $page->last_updated_at ? $page->last_updated_at->format('F j, Y \a\t H:i') : 'Not specified' }}</p>
                </div>
                <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="inline-flex items-center text-brand-orange-600 hover:text-brand-orange-700 font-medium transition-colors">
                    Back to Top
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .prose p {
        @apply mb-4;
    }

    .prose h2 {
        @apply text-3xl font-bold text-gray-900 mt-8 mb-4;
    }

    .prose h3 {
        @apply text-2xl font-bold text-gray-900 mt-6 mb-3;
    }

    .prose h4 {
        @apply text-lg font-bold text-gray-900 mt-4 mb-2;
    }

    .prose ul, .prose ol {
        @apply my-4 ml-6;
    }

    .prose li {
        @apply mb-2;
    }

    .prose a {
        @apply text-brand-orange-600 hover:text-brand-orange-700 font-medium transition-colors;
    }

    .prose code {
        @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono text-gray-800;
    }

    .prose blockquote {
        @apply border-l-4 border-brand-orange-600 pl-4 italic text-gray-700 my-4;
    }
</style>
@endsection
