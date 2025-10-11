@extends('admin.layout')

@section('title', 'Film Category Details')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.film-categories.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $filmCategory->name }}</h1>
                    <p class="text-gray-600 mt-2">Film category details and information</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.film-categories.edit', $filmCategory) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Category
                </a>
            </div>
        </div>
    </div>

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Category Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $filmCategory->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $filmCategory->slug }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $filmCategory->description ?: 'No description provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <div class="w-8 h-8 rounded border" style="background-color: {{ $filmCategory->color }}"></div>
                            <span class="text-sm text-gray-900 font-mono">{{ $filmCategory->color }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Active Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $filmCategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $filmCategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Sort Order</span>
                        <span class="text-sm text-gray-900">{{ $filmCategory->sort_order }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Created</span>
                        <span class="text-sm text-gray-900">{{ $filmCategory->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Updated</span>
                        <span class="text-sm text-gray-900">{{ $filmCategory->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Films Count -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Films in Category</h3>
                
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">{{ $filmCategory->filmPortfolios()->count() }}</div>
                    <p class="text-sm text-gray-600">Total films</p>
                </div>
                
                @if($filmCategory->filmPortfolios()->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.film-portfolios.index', ['category' => $filmCategory->id]) }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            View all films in this category →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Films in Category -->
    @if($filmCategory->filmPortfolios()->count() > 0)
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Films in this Category</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Film</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($filmCategory->filmPortfolios()->limit(5)->get() as $film)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $film->image_url }}" alt="{{ $film->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $film->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($film->description, 30) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $film->genre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $film->year }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if($film->is_featured)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Featured
                                                </span>
                                            @endif
                                            @if($film->is_published)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.film-portfolios.show', $film) }}" class="text-gray-400 hover:text-gray-600 mr-3" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.film-portfolios.edit', $film) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($filmCategory->filmPortfolios()->count() > 5)
                    <div class="px-6 py-4 border-t border-gray-200 text-center">
                        <a href="{{ route('admin.film-portfolios.index', ['category' => $filmCategory->id]) }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                            View all {{ $filmCategory->filmPortfolios()->count() }} films →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
