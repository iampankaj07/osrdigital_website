@extends('admin.layout')

@section('title', 'Edit Hero Section')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.hero-sections.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Hero Section</h1>
                <p class="text-gray-600 mt-2">Update hero section for {{ ucfirst($heroSection->page) }} page</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.hero-sections.update', $heroSection) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Page Selection -->
                <div>
                    <label for="page" class="block text-sm font-medium text-gray-700 mb-2">
                        Page <span class="text-red-500">*</span>
                    </label>
                    <select name="page" id="page" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('page') border-red-500 @enderror" required>
                        <option value="">Select a page</option>
                        @foreach($pages as $key => $value)
                            <option value="{{ $key }}" {{ old('page', $heroSection->page) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', $heroSection->sort_order) }}" min="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Title -->
            <div class="mt-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" value="{{ old('title', $heroSection->title) }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtitle -->
            <div class="mt-6">
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('subtitle') border-red-500 @enderror" value="{{ old('subtitle', $heroSection->subtitle) }}">
                @error('subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="content" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('content') border-red-500 @enderror" required>{{ old('content', $heroSection->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Use HTML tags for formatting. You can include links, bold text, etc.</p>
            </div>

            <!-- Button Configuration -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Button Configuration</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Primary Button -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-700">Primary Button</h4>
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="button_text" id="button_text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('button_text') border-red-500 @enderror" value="{{ old('button_text', $heroSection->button_text) }}">
                            @error('button_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="button_link" id="button_link" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('button_link') border-red-500 @enderror" value="{{ old('button_link', $heroSection->button_link) }}">
                            @error('button_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Secondary Button -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-700">Secondary Button</h4>
                        <div>
                            <label for="button_text_secondary" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="button_text_secondary" id="button_text_secondary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('button_text_secondary') border-red-500 @enderror" value="{{ old('button_text_secondary', $heroSection->button_text_secondary) }}">
                            @error('button_text_secondary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="button_link_secondary" class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="button_link_secondary" id="button_link_secondary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('button_link_secondary') border-red-500 @enderror" value="{{ old('button_link_secondary', $heroSection->button_link_secondary) }}">
                            @error('button_link_secondary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" value="1" {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.hero-sections.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save mr-2"></i>
                    Update Hero Section
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
