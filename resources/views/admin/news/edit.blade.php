@extends('admin.layout')

@section('title', 'Edit News Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit News Article</h1>
            <p class="text-gray-600">Update the news article details</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to News
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form id="newsForm" method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt *</label>
                    <textarea id="excerpt" name="excerpt" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $news->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <div id="quill-editor" style="height: 300px;">{!! old('content', $news->content) !!}</div>
                    <textarea id="content" name="content" style="display: none;">{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    
                    @if($news->featured_image)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            <div class="flex items-center space-x-4">
                                <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="h-20 w-20 object-cover rounded-lg">
                                <div>
                                    <p class="text-sm text-gray-600">Current featured image</p>
                                    <p class="text-xs text-gray-500">Upload a new image to replace it</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" id="featured_image" name="featured_image" accept=".png,.svg,.jpg,.jpeg" class="featured-image-filepond">
                    <p class="text-sm text-gray-500 mt-1">PNG, SVG, JPG, JPEG up to 5MB</p>
                    @error('featured_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author Name -->
                <div>
                    <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Author Name *</label>
                    <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $news->author_name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('author_name') border-red-500 @enderror">
                    @error('author_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <input type="text" id="tags" name="tags" value="{{ old('tags', is_array($news->tags) ? implode(', ', $news->tags) : $news->tags) }}"
                           placeholder="Enter tags separated by commas"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tags') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Separate multiple tags with commas</p>
                    @error('tags')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status and Published Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Published Date *</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Update Article
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill.js with custom configuration
    const quill = QuillConfig.init('#quill-editor');

    // Initialize FilePond for featured image
    const featuredImagePond = FilePond.create(document.querySelector('.featured-image-filepond'), {
        name: 'featured_image',
        acceptedFileTypes: ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'],
        maxFileSize: '2MB',
        allowRevert: false,
        allowRemove: true,
        allowReplace: true,
        allowImagePreview: true,
        imagePreviewHeight: 200,
        labelIdle: 'Drag & Drop your featured image or <span class="filepond--label-action">Browse</span>',
        labelInvalidType: 'Invalid file type. Please upload PNG, SVG, JPG, or JPEG.',
        labelFileSizeTooBig: 'File is too large. Maximum size is 2MB.',
        server: {
            process: {
                url: '/upload/news-featured-image',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                withCredentials: true,
                onload: (response) => {
                    const result = JSON.parse(response);
                    if (result.success) {
                        console.log('Featured image uploaded successfully:', result);
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'featured_image_path';
                        hiddenInput.value = result.url;
                        document.getElementById('newsForm').appendChild(hiddenInput);
                    }
                    return response;
                },
                onerror: (response) => {
                    console.error('Featured image upload failed:', response);
                    showNotification('Featured image upload failed. Please try again.', 'error');
                    return response;
                }
            }
        }
    });

    // Load existing image if available
    @if($news->featured_image)
        const existingImageUrl = '{{ Storage::url($news->featured_image) }}';
        if (existingImageUrl && !existingImageUrl.includes('via.placeholder.com')) {
            featuredImagePond.addFile(existingImageUrl, {
                type: 'image/*',
                metadata: {
                    poster: existingImageUrl
                }
            });
        }
    @endif
});
</script>
@endsection
