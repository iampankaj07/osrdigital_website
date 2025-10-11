@extends('admin.layout')

@section('title', 'Film Portfolio Details')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.film-portfolios.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $filmPortfolio->title }}</h1>
                    <p class="text-gray-600 mt-2">Film portfolio details and information</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.film-portfolios.edit', $filmPortfolio) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Film
                </a>
            </div>
        </div>
    </div>

    <!-- Film Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Film Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $filmPortfolio->title }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $filmPortfolio->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Genre</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $filmPortfolio->genre }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Year</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $filmPortfolio->year }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($filmPortfolio->rating)
                                    <span class="flex items-center">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        {{ $filmPortfolio->rating }}/10
                                    </span>
                                @else
                                    <span class="text-gray-400">Not rated</span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $filmPortfolio->duration ?: 'Not specified' }}</p>
                        </div>
                    </div>
                    
                    @if($filmPortfolio->video_url)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Video URL</label>
                            <a href="{{ $filmPortfolio->video_url }}" target="_blank" class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                {{ $filmPortfolio->video_url }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Film Image -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Film Image</h3>
                
                <div class="text-center">
                    <img src="{{ $filmPortfolio->image_url }}" alt="{{ $filmPortfolio->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                    <p class="text-sm text-gray-600">Featured image</p>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Category</h3>
                
                <div class="text-center">
                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-white" style="background-color: {{ $filmPortfolio->category->color }}">
                        {{ $filmPortfolio->category->name }}
                    </span>
                    <p class="mt-2 text-sm text-gray-600">{{ $filmPortfolio->category->description }}</p>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Featured</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $filmPortfolio->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $filmPortfolio->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Published</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $filmPortfolio->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $filmPortfolio->is_published ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Sort Order</span>
                        <span class="text-sm text-gray-900">{{ $filmPortfolio->sort_order }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Created</span>
                        <span class="text-sm text-gray-900">{{ $filmPortfolio->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Updated</span>
                        <span class="text-sm text-gray-900">{{ $filmPortfolio->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    <form action="{{ route('admin.film-portfolios.toggle-featured', $filmPortfolio) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition-colors duration-200">
                            {{ $filmPortfolio->is_featured ? 'Remove from Featured' : 'Add to Featured' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.film-portfolios.toggle-published', $filmPortfolio) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-3 py-2 text-sm font-medium {{ $filmPortfolio->is_published ? 'text-red-700 bg-red-100 hover:bg-red-200' : 'text-green-700 bg-green-100 hover:bg-green-200' }} rounded-lg transition-colors duration-200">
                            {{ $filmPortfolio->is_published ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
