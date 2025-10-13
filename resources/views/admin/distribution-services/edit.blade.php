@extends('admin.layout')

@section('title', 'Edit Distribution Service')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.distribution-services.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Distribution Service</h1>
                <p class="text-gray-600 mt-2">Update service: {{ $distributionService->title }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.distribution-services.update', $distributionService) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" value="{{ old('title', $distributionService->title) }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link -->
                    <div>
                        <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                        <input type="text" name="link" id="link" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('link') border-red-500 @enderror" value="{{ old('link', $distributionService->link) }}" placeholder="/business">
                        @error('link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" required>{{ old('description', $distributionService->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Icon Configuration Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Icon Configuration</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Icon Type -->
                    <div>
                        <label for="icon_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Icon Type <span class="text-red-500">*</span>
                        </label>
                        <select name="icon_type" id="icon_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('icon_type') border-red-500 @enderror" required>
                            <option value="">Select icon type</option>
                            <option value="svg" {{ old('icon_type', $distributionService->icon_type) == 'svg' ? 'selected' : '' }}>SVG Code</option>
                            <option value="font-awesome" {{ old('icon_type', $distributionService->icon_type) == 'font-awesome' ? 'selected' : '' }}>Font Awesome</option>
                            <option value="image" {{ old('icon_type', $distributionService->icon_type) == 'image' ? 'selected' : '' }}>Image URL</option>
                        </select>
                        @error('icon_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" value="{{ old('sort_order', $distributionService->sort_order) }}" min="0">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Icon Data -->
                <div class="mt-6">
                    <label for="icon_data" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon Data <span class="text-red-500">*</span>
                    </label>
                    <div id="icon-input-container">
                        <!-- SVG Input -->
                        <div id="svg-input" class="icon-input-type" style="display: none;">
                            <textarea name="icon_data" id="icon_data_svg" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm" placeholder="<svg class=&quot;w-6 h-6&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;>...</svg>">{{ old('icon_data', $distributionService->icon_type === 'svg' ? $distributionService->icon_data : '') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">Paste your SVG code here. Make sure to include proper classes like "w-6 h-6".</p>
                        </div>

                        <!-- Font Awesome Input -->
                        <div id="font-awesome-input" class="icon-input-type" style="display: none;">
                            <input type="text" name="icon_data" id="icon_data_fa" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="fas fa-video" value="{{ old('icon_data', $distributionService->icon_type === 'font-awesome' ? $distributionService->icon_data : '') }}">
                            <p class="mt-2 text-sm text-gray-500">Enter Font Awesome class (e.g., "fas fa-video", "fab fa-youtube").</p>
                        </div>

                        <!-- Image Input -->
                        <div id="image-input" class="icon-input-type" style="display: none;">
                            <input type="text" name="icon_data" id="icon_data_img" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="https://example.com/icon.png" value="{{ old('icon_data', $distributionService->icon_type === 'image' ? $distributionService->icon_data : '') }}">
                            <p class="mt-2 text-sm text-gray-500">Enter the full URL to your image file.</p>
                        </div>
                    </div>
                    @error('icon_data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Settings & Configuration</h3>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" value="1" {{ old('is_active', $distributionService->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.distribution-services.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save mr-2"></i>
                    Update Service
                </button>
            </div>
        </form>
    </div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconTypeSelect = document.getElementById('icon_type');
    const iconInputContainer = document.getElementById('icon-input-container');
    const iconInputs = {
        'svg': document.getElementById('svg-input'),
        'font-awesome': document.getElementById('font-awesome-input'),
        'image': document.getElementById('image-input')
    };

    function showIconInput(type) {
        // Hide all inputs
        Object.values(iconInputs).forEach(input => {
            input.style.display = 'none';
        });

        // Show selected input
        if (iconInputs[type]) {
            iconInputs[type].style.display = 'block';
        }
    }

    // Handle icon type change
    iconTypeSelect.addEventListener('change', function() {
        showIconInput(this.value);
    });

    // Show initial input based on current value
    const currentType = iconTypeSelect.value;
    if (currentType) {
        showIconInput(currentType);
    }
});
</script>
@endsection

@endsection
