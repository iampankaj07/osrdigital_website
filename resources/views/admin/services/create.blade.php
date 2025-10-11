@extends('admin.layout')

@section('title', 'Create Service')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.services.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Service</h1>
                <p class="text-gray-600 mt-2">Add a new service to showcase what you do</p>
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

    <form method="POST" action="{{ route('admin.services.store') }}" id="serviceForm">
        @csrf

        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" placeholder="e.g., Content Acquisition">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror" placeholder="0">
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Icon Selection -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Icon Selection</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon *</label>
                <div class="flex items-center space-x-4">
                    <select name="icon" id="icon" required class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('icon') border-red-500 @enderror">
                        <option value="fas fa-bullseye" {{ old('icon') == 'fas fa-bullseye' ? 'selected' : '' }}>Target (fas fa-bullseye)</option>
                        <option value="fas fa-play-circle" {{ old('icon') == 'fas fa-play-circle' ? 'selected' : '' }}>Play Circle (fas fa-play-circle)</option>
                        <option value="fas fa-globe" {{ old('icon') == 'fas fa-globe' ? 'selected' : '' }}>Globe (fas fa-globe)</option>
                        <option value="fas fa-palette" {{ old('icon') == 'fas fa-palette' ? 'selected' : '' }}>Palette (fas fa-palette)</option>
                        <option value="fas fa-cogs" {{ old('icon') == 'fas fa-cogs' ? 'selected' : '' }}>Cogs (fas fa-cogs)</option>
                        <option value="fas fa-rocket" {{ old('icon') == 'fas fa-rocket' ? 'selected' : '' }}>Rocket (fas fa-rocket)</option>
                        <option value="fas fa-chart-line" {{ old('icon') == 'fas fa-chart-line' ? 'selected' : '' }}>Chart Line (fas fa-chart-line)</option>
                        <option value="fas fa-users" {{ old('icon') == 'fas fa-users' ? 'selected' : '' }}>Users (fas fa-users)</option>
                        <option value="fas fa-handshake" {{ old('icon') == 'fas fa-handshake' ? 'selected' : '' }}>Handshake (fas fa-handshake)</option>
                        <option value="fas fa-star" {{ old('icon') == 'fas fa-star' ? 'selected' : '' }}>Star (fas fa-star)</option>
                        <option value="fas fa-lightbulb" {{ old('icon') == 'fas fa-lightbulb' ? 'selected' : '' }}>Lightbulb (fas fa-lightbulb)</option>
                        <option value="fas fa-trophy" {{ old('icon') == 'fas fa-trophy' ? 'selected' : '' }}>Trophy (fas fa-trophy)</option>
                    </select>
                    <div class="text-3xl text-purple-600" id="icon_preview">
                        <i class="{{ old('icon', 'fas fa-bullseye') }}"></i>
                    </div>
                </div>
                @error('icon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" placeholder="Describe this service...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Settings</h3>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">Mark as featured service</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Show this service on website</label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.services.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Create Service
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
// Icon preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const iconSelect = document.getElementById('icon');
    const iconPreview = document.getElementById('icon_preview');

    if (iconSelect && iconPreview) {
        iconSelect.addEventListener('change', function() {
            const iconClass = this.value;
            iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        });
    }
});
</script>
@endsection

