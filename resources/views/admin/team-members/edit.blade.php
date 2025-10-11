@extends('admin.layout')

@section('title', 'Edit Team Member')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.team-members.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Team Member</h1>
                <p class="text-gray-600 mt-2">Update team member information</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.team-members.update', $teamMember) }}" id="teamMemberForm">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $teamMember->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" placeholder="e.g., Sarah Chen">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                    <input type="text" name="position" value="{{ old('position', $teamMember->position) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('position') border-red-500 @enderror" placeholder="e.g., CEO & Founder">
                    @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                    <input type="text" name="department" value="{{ old('department', $teamMember->department) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('department') border-red-500 @enderror" placeholder="e.g., Leadership">
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" placeholder="0">
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $teamMember->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror" placeholder="e.g., sarah@osrdigital.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-700">Avatar Upload</label>
                        <button type="button" onclick="clearAllFiles()" class="text-sm text-red-600 hover:text-red-800 font-medium">
                            <i class="fas fa-trash mr-1"></i>Clear All
                        </button>
                    </div>
                    <input type="file" id="avatar_upload" name="avatar" class="filepond-input" accept=".png,.svg,.jpg,.jpeg">
                    <input type="hidden" name="avatar" id="avatar_url" value="{{ old('avatar', $teamMember->avatar) }}">
                    @error('avatar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', $teamMember->linkedin) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('linkedin') border-red-500 @enderror" placeholder="https://linkedin.com/in/username">
                    @error('linkedin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
                    <input type="url" name="twitter" value="{{ old('twitter', $teamMember->twitter) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('twitter') border-red-500 @enderror" placeholder="https://twitter.com/username">
                    @error('twitter')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Settings</h3>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Show this team member on website</label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.team-members.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Update Team Member
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

    // Get existing avatar URL
    const existingAvatarUrl = '{{ $teamMember->avatar }}';
    
    // Create FilePond instance for avatar
    const avatarPond = FilePond.create(document.querySelector('#avatar_upload'), {
        name: 'avatar',
        server: {
            process: {
                url: '/upload/team-member-avatar',
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

    // Load existing image if available (skip placeholder images)
    if (existingAvatarUrl && !existingAvatarUrl.includes('via.placeholder.com')) {
        avatarPond.addFile(existingAvatarUrl, {
            type: 'image/*',
            metadata: {
                poster: existingAvatarUrl
            }
        });
    }

    // Add clear all files functionality
    window.clearAllFiles = function() {
        avatarPond.removeFiles();
    };

    // Handle form submission
    document.getElementById('teamMemberForm').addEventListener('submit', function(e) {
        // Ensure the hidden input has the correct value
        const avatarUrl = document.getElementById('avatar_url').value;
        if (avatarUrl) {
            document.querySelector('input[name="avatar"]').value = avatarUrl;
        }
    });
});
</script>
@endsection
