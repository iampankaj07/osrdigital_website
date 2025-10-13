@extends('admin.layout')

@section('title', 'News Category Details')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Category Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.news-categories.edit', $newsCategory) }}" class="btn btn-dark">
                <i class="fas fa-edit mr-2"></i>
                Edit Category
            </a>
            <a href="{{ route('admin.news-categories.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Categories
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $newsCategory->name }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Color</label>
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded border" style="background-color: {{ $newsCategory->color }}"></div>
                            <span class="text-sm text-gray-900">{{ $newsCategory->color }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $newsCategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $newsCategory->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Sort Order</label>
                        <span class="text-sm text-gray-900">{{ $newsCategory->sort_order }}</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                        <span class="text-sm text-gray-900">{{ $newsCategory->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                @if($newsCategory->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                        <p class="text-gray-900">{{ $newsCategory->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- News Articles -->
        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">News Articles ({{ $newsCategory->news->count() }})</h3>

                @if($newsCategory->news->count() > 0)
                    <div class="space-y-3">
                        @foreach($newsCategory->news->take(5) as $article)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-newspaper text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $article->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $article->published_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach

                        @if($newsCategory->news->count() > 5)
                            <p class="text-sm text-gray-500 text-center">And {{ $newsCategory->news->count() - 5 }} more articles...</p>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500 text-center">No articles in this category yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
