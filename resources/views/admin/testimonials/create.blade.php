@extends('admin.layout')

@section('title', 'Create Testimonial')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.testimonials.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create Testimonial</h1>
                <p class="text-gray-600 mt-2">Add a new partner testimonial</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="space-y-8">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    
                    <div class="space-y-6">
                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Testimonial Content <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" id="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('content') border-red-500 @enderror" placeholder="Enter the testimonial content..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Author Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    Role/Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('role') border-red-500 @enderror" value="{{ old('role') }}" required>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company" id="company" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('company') border-red-500 @enderror" value="{{ old('company') }}" required>
                                @error('company')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Project -->
                            <div>
                                <label for="project" class="block text-sm font-medium text-gray-700 mb-2">
                                    Project (Optional)
                                </label>
                                <input type="text" name="project" id="project" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('project') border-red-500 @enderror" value="{{ old('project') }}" placeholder="e.g., The Last Horizon">
                                @error('project')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Settings -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Media & Settings</h3>
                    
                    <div class="space-y-6">
                        <!-- Avatar Upload -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="avatar" class="block text-sm font-medium text-gray-700">
                                    Author Avatar (Optional)
                                </label>
                                <button type="button" onclick="clearAllFiles()" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    <i class="fas fa-trash mr-1"></i>Clear All
                                </button>
                            </div>
                            <input type="file" name="avatar" id="avatar" class="filepond" accept=".png,.svg,.jpg,.jpeg">
                            <input type="hidden" name="avatar_url" id="avatar_url" value="{{ old('avatar_url') }}">
                            <p class="mt-1 text-sm text-gray-500">Upload a profile picture for the author. If not provided, initials will be used.</p>
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sort Order
                                </label>
                                <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_featured" id="is_featured" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                            Featured
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_published" id="is_published" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" {{ old('is_published', true) ? 'checked' : '' }}>
                                        <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                            Published
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Create Testimonial
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<!-- FilePond CSS -->
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<!-- FilePond JS -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // Create FilePond instance for avatar upload
    const avatarPond = FilePond.create(document.querySelector('#avatar'), {
        name: 'avatar',
        server: {
            process: {
                url: '/upload/testimonial-image',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                withCredentials: true,
                onload: (response) => {
                    const data = JSON.parse(response);
                    if (data.success) {
                        document.getElementById('avatar_url').value = data.url;
                        return data.url;
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                },
                onerror: (response) => {
                    console.error('Upload error:', response);
                    throw new Error('Upload failed');
                }
            }
        },
        allowImagePreview: true,
        imagePreviewHeight: 120,
        allowImageCrop: true,
        imageCropAspectRatio: '1:1',
        allowImageResize: true,
        imageResizeTargetWidth: 300,
        imageResizeTargetHeight: 300,
        imageResizeMode: 'cover',
        acceptedFileTypes: ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'],
        maxFileSize: '2MB',
        labelIdle: 'Drag & Drop avatar or <span class="filepond--label-action">Browse</span>',
        labelInvalidField: 'Field contains invalid files',
        labelFileWaitingForSize: 'Waiting for size',
        labelFileSizeNotAvailable: 'Size not available',
        labelFileLoading: 'Loading',
        labelFileLoadError: 'Error during load',
        labelFileProcessing: 'Uploading',
        labelFileProcessingComplete: 'Upload complete',
        labelFileProcessingAborted: 'Upload cancelled',
        labelFileProcessingError: 'Error during upload',
        labelFileProcessingRevertError: 'Error during revert',
        labelFileRemoveError: 'Error during remove',
        labelTapToCancel: 'tap to cancel',
        labelTapToRetry: 'tap to retry',
        labelTapToUndo: 'tap to undo',
        labelButtonRemoveItem: 'Clear',
        labelButtonAbortItemLoad: 'Abort',
        labelButtonRetryItemLoad: 'Retry',
        labelButtonAbortItemProcessing: 'Cancel',
        labelButtonUndoItemProcessing: 'Undo',
        labelButtonRetryItemProcessing: 'Retry',
        labelButtonProcessItem: 'Upload'
    });

    // Add clear all files functionality
    window.clearAllFiles = function() {
        avatarPond.removeFiles();
    };
});
</script>
@endsection
