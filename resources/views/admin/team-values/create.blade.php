@extends('admin.layout')

@section('title', 'Create Team Value')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.team-values.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Team Value</h1>
                <p class="text-gray-600 mt-2">Add a new team value to showcase company principles</p>
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

    <form method="POST" action="{{ route('admin.team-values.store') }}" id="teamValueForm">
        @csrf

        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" placeholder="e.g., Innovation">
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

        <!-- Icon Selection with Search -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Icon Selection</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon *</label>
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="text" id="icon_search" placeholder="Search icons..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent mb-2">
                        <select name="icon" id="icon" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('icon') border-red-500 @enderror" size="10">
                            <option value="fas fa-lightbulb" {{ old('icon') == 'fas fa-lightbulb' ? 'selected' : '' }}>💡 Lightbulb (fas fa-lightbulb)</option>
                            <option value="fas fa-handshake" {{ old('icon') == 'fas fa-handshake' ? 'selected' : '' }}>🤝 Handshake (fas fa-handshake)</option>
                            <option value="fas fa-chart-line" {{ old('icon') == 'fas fa-chart-line' ? 'selected' : '' }}>📈 Chart Line (fas fa-chart-line)</option>
                            <option value="fas fa-globe" {{ old('icon') == 'fas fa-globe' ? 'selected' : '' }}>🌐 Globe (fas fa-globe)</option>
                            <option value="fas fa-star" {{ old('icon') == 'fas fa-star' ? 'selected' : '' }}>⭐ Star (fas fa-star)</option>
                            <option value="fas fa-heart" {{ old('icon') == 'fas fa-heart' ? 'selected' : '' }}>❤️ Heart (fas fa-heart)</option>
                            <option value="fas fa-users" {{ old('icon') == 'fas fa-users' ? 'selected' : '' }}>👥 Users (fas fa-users)</option>
                            <option value="fas fa-rocket" {{ old('icon') == 'fas fa-rocket' ? 'selected' : '' }}>🚀 Rocket (fas fa-rocket)</option>
                            <option value="fas fa-shield-alt" {{ old('icon') == 'fas fa-shield-alt' ? 'selected' : '' }}>🛡️ Shield (fas fa-shield-alt)</option>
                            <option value="fas fa-gem" {{ old('icon') == 'fas fa-gem' ? 'selected' : '' }}>💎 Gem (fas fa-gem)</option>
                            <option value="fas fa-trophy" {{ old('icon') == 'fas fa-trophy' ? 'selected' : '' }}>🏆 Trophy (fas fa-trophy)</option>
                            <option value="fas fa-award" {{ old('icon') == 'fas fa-award' ? 'selected' : '' }}>🏆 Award (fas fa-award)</option>
                            <option value="fas fa-medal" {{ old('icon') == 'fas fa-medal' ? 'selected' : '' }}>🏅 Medal (fas fa-medal)</option>
                            <option value="fas fa-crown" {{ old('icon') == 'fas fa-crown' ? 'selected' : '' }}>👑 Crown (fas fa-crown)</option>
                            <option value="fas fa-bullseye" {{ old('icon') == 'fas fa-bullseye' ? 'selected' : '' }}>🎯 Bullseye (fas fa-bullseye)</option>
                            <option value="fas fa-check-circle" {{ old('icon') == 'fas fa-check-circle' ? 'selected' : '' }}>✅ Check Circle (fas fa-check-circle)</option>
                            <option value="fas fa-thumbs-up" {{ old('icon') == 'fas fa-thumbs-up' ? 'selected' : '' }}>👍 Thumbs Up (fas fa-thumbs-up)</option>
                            <option value="fas fa-gift" {{ old('icon') == 'fas fa-gift' ? 'selected' : '' }}>🎁 Gift (fas fa-gift)</option>
                            <option value="fas fa-coffee" {{ old('icon') == 'fas fa-coffee' ? 'selected' : '' }}>☕ Coffee (fas fa-coffee)</option>
                            <option value="fas fa-gamepad" {{ old('icon') == 'fas fa-gamepad' ? 'selected' : '' }}>🎮 Gamepad (fas fa-gamepad)</option>
                        </select>
                    </div>
                    <div class="text-3xl" style="color: #EC681D" id="icon_preview">
                        <i class="{{ old('icon', 'fas fa-lightbulb') }}"></i>
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
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" placeholder="Describe this team value...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Settings</h3>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Show this value on team page</label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.team-values.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Create Team Value
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
// Icon search and preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const iconSearch = document.getElementById('icon_search');
    const iconSelect = document.getElementById('icon');
    const iconPreview = document.getElementById('icon_preview');

    // Icon search functionality
    if (iconSearch && iconSelect) {
        iconSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = iconSelect.querySelectorAll('option');
            
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    }

    // Icon preview functionality
    if (iconSelect && iconPreview) {
        iconSelect.addEventListener('change', function() {
            const iconClass = this.value;
            iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        });
    }
});
</script>
@endsection




