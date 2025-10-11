@extends('admin.layout')

@section('title', 'View Hero Section')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.hero-sections.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Hero Section Details</h1>
                    <p class="text-gray-600 mt-2">{{ ucfirst($heroSection->page) }} page hero section</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.hero-sections.edit', $heroSection) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.hero-sections.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Hero Section Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Hero Section Information</h3>
                
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Page</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($heroSection->page) }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $heroSection->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $heroSection->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $heroSection->sort_order }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $heroSection->created_at->format('M d, Y H:i') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $heroSection->updated_at->format('M d, Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Button Configuration -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Button Configuration</h3>
                
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Primary Button</dt>
                        <dd class="mt-1">
                            @if($heroSection->shouldShowButton())
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $heroSection->button_text }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $heroSection->button_link }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-500">Not configured</span>
                            @endif
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Secondary Button</dt>
                        <dd class="mt-1">
                            @if($heroSection->shouldShowSecondaryButton())
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $heroSection->button_text_secondary }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $heroSection->button_link_secondary }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-500">Not configured</span>
                            @endif
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Preview -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Content Preview</h3>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <!-- Badge -->
                    @if($heroSection->subtitle)
                        <div class="mb-6">
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                <div class="w-2 h-2 rounded-full bg-gray-400 mr-2"></div>
                                {{ $heroSection->subtitle }}
                            </div>
                        </div>
                    @endif

                    <!-- Title -->
                    <div class="mb-6">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ $heroSection->title }}
                        </h1>
                    </div>

                    <!-- Content -->
                    <div class="mb-8">
                        <div class="text-lg text-gray-600 leading-relaxed" style="white-space: pre-wrap;">{{ $heroSection->content }}</div>
                    </div>

                    <!-- Buttons -->
                    @if($heroSection->shouldShowButton() || $heroSection->shouldShowSecondaryButton())
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($heroSection->shouldShowButton())
                                <a href="{{ $heroSection->button_link }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors duration-200">
                                    {{ $heroSection->button_text }}
                                </a>
                            @endif
                            @if($heroSection->shouldShowSecondaryButton())
                                <a href="{{ $heroSection->button_link_secondary }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                                    {{ $heroSection->button_text_secondary }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection