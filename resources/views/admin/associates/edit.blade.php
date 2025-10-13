@extends('admin.layout')

@section('title', 'Edit Associate')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.associates.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Associate</h1>
                <p class="text-gray-600 mt-2">Update associate: {{ $associate->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.associates.update', $associate) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" value="{{ old('name', $associate->name) }}" required>
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
                    <input type="file" name="logo" id="logo"  accept=".png,.svg,.jpg,.jpeg">
                    <input type="hidden" name="logo" id="logo_url" value="{{ old('logo', $associate->logo) }}">

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
                        <input type="text" name="website" id="website" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('website') border-red-500 @enderror" value="{{ old('website', $associate->website) }}" placeholder="https://example.com">
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
                        <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', $associate->sort_order) }}" min="0">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" value="1" {{ old('is_active', $associate->is_active) ? 'checked' : '' }}>
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
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save mr-2"></i>
                    Update Associate
                </button>
            </div>
        </form>
    </div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('associateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    });
});
</script>
@endsection

@endsection
