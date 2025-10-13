@extends('admin.layout')

@section('title', 'View News Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">View News Article</h1>
            <p class="text-gray-600">Article details and preview</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-dark">
                <i class="fas fa-edit mr-2"></i>
                Edit Article
            </a>
            <a href="{{ route('admin.news.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to News
            </a>
        </div>
    </div>

    <!-- Article Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <!-- Featured Image -->
            @if($news->featured_image)
                <div class="mb-6">
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-64 object-cover rounded-lg">
                </div>
            @endif

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                <div class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $news->author_name }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    <span>{{ $news->published_at ? $news->published_at->format('M d, Y \a\t g:i A') : 'Not published' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($news->status) }}
                    </span>
                </div>
                @if($news->featured)
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-star mr-1"></i>
                            Featured
                        </span>
                    </div>
                @endif
            </div>

            <!-- Tags -->
            @if($news->tags && count($news->tags) > 0)
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <span class="inline-flex px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded-full">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Excerpt -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Excerpt</h3>
                <p class="text-gray-700 leading-relaxed">{{ $news->excerpt }}</p>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Content</h3>
                <div class="prose max-w-none text-gray-700">
                    {!! $news->content !!}
                </div>
            </div>

            <!-- Article Stats -->
            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ Str::length($news->content) }}</div>
                        <div class="text-sm text-gray-600">Characters</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ str_word_count($news->content) }}</div>
                        <div class="text-sm text-gray-600">Words</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ ceil(str_word_count($news->content) / 200) }}</div>
                        <div class="text-sm text-gray-600">Min Read</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Created: {{ $news->created_at->format('M d, Y \a\t g:i A') }}
                    @if($news->updated_at != $news->created_at)
                        | Updated: {{ $news->updated_at->format('M d, Y \a\t g:i A') }}
                    @endif
                </div>
                <div class="flex space-x-3">
                    <form action="{{ route('admin.news.toggle-featured', $news) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 {{ $news->featured ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-purple-600 hover:bg-purple-700' }} text-white rounded-lg transition-colors">
                            <i class="fas fa-star mr-2"></i>
                            {{ $news->featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
