@extends('admin.layout')

@section('title', 'Create Associate')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.associates.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Associate</h1>
                <p class="text-gray-600 mt-2">Add a new associate or partner</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.associates.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Logo Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Logo & Branding</h3>
                
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-medium text-gray-700">Logo Image</label>
                        <button type="button" onclick="clearAllFiles()" class="text-sm text-red-600 hover:text-red-800 font-medium">
                            <i class="fas fa-trash mr-1"></i>Clear All
                        </button>
                    </div>
                    <input type="file" name="logo" id="logo" class="filepond" accept=".png,.svg,.jpg,.jpeg">
                    <input type="hidden" name="logo" id="logo_url" value="{{ old('logo') }}">
                    
                    @error('logo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Upload an image file (PNG, SVG, JPG, JPEG) - Max 2MB</p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Content & Details</h3>
                
                <div class="space-y-6">

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                        <input type="text" name="website" id="website" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('website') border-red-500 @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Settings & Configuration</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.associates.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Create Associate
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginImageResize);
    FilePond.registerPlugin(FilePondPluginImageCrop);

    // Create FilePond instance
    const pond = FilePond.create(document.getElementById('logo'), {
        name: 'logo',
        acceptedFileTypes: ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'],
        maxFileSize: '2MB',
        imageResizeTargetWidth: 300,
        imageResizeTargetHeight: 300,
        imageResizeMode: 'contain',
        imageResizeUpscale: false,
        timeout: 30000, // 30 seconds timeout
        allowRevert: false, // Prevent reverting to server
        allowRemove: true, // Allow removing files
        allowReplace: true, // Allow replacing files
        allowImagePreview: true,
        imagePreviewHeight: 200,
        server: {
            process: {
                url: '{{ app()->environment('production') ? '/upload/associate-image-production' : '/upload/associate-image' }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                withCredentials: true,
                onload: (response) => {
                    console.log('Raw response:', response);
                    try {
                        const result = JSON.parse(response);
                        console.log('Parsed response:', result);
                        if (result.success && result.url) {
                            console.log('Upload successful, returning URL:', result.url);
                            document.getElementById('logo_url').value = result.url;
                            return result.url;
                        } else {
                            console.error('Upload failed:', result.message || 'Unknown error');
                            return null;
                        }
                    } catch (error) {
                        console.error('Error parsing upload response:', error);
                        console.error('Response was:', response);
                        return null;
                    }
                },
                onerror: (response) => {
                    console.error('Upload failed with error:', response);
                    let errorMessage = 'Image upload failed. Please try again.';
                    try {
                        const errorData = JSON.parse(response);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        console.error('Could not parse error response:', e);
                    }
                    alert(errorMessage);
                }
            }
        },
        onprocessfile: (error, file) => {
            if (error) {
                console.error('FilePond process error:', error);
                alert('Image upload failed: ' + error);
            } else {
                console.log('File processed successfully:', file);
            }
        },
        onprocessfileprogress: (file, progress) => {
            console.log('Upload progress:', progress);
        },
        onprocessfileload: (file) => {
            console.log('File loaded successfully:', file);
        },
        onprocessfileerror: (file, error) => {
            console.error('File process error:', error);
            alert('Image upload failed: ' + error);
        },
        // Add clear button functionality
        labelButtonRemoveItem: 'Clear',
        labelButtonProcessItem: 'Upload',
        labelIdle: 'Drag & Drop your logo or <span class="filepond--label-action">Browse</span>',
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
        labelButtonAbortItemLoad: 'Abort',
        labelButtonRetryItemLoad: 'Retry',
        labelButtonAbortItemProcessing: 'Cancel',
        labelButtonUndoItemProcessing: 'Undo',
        labelButtonRetryItemProcessing: 'Retry'
    });

    // Add clear all files functionality
    window.clearAllFiles = function() {
        pond.removeFiles();
    };
});
</script>
@endsection
