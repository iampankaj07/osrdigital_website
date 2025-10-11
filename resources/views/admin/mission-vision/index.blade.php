@extends('admin.layout')

@section('title', 'Mission & Vision')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Mission & Vision</h1>
        <button onclick="saveMissionVision()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-save mr-2"></i>
            Save Changes
        </button>
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

    <form method="POST" action="{{ route('admin.mission-vision.update') }}" id="missionVisionForm">
        @csrf
        @method('PUT')
        
        <!-- Mission Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Our Mission</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mission Title</label>
                        <input type="text" name="mission_title" value="{{ old('mission_title', $missionVision->mission_title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('mission_title') border-red-500 @enderror">
                        @error('mission_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mission Icon</label>
                        <div class="flex items-center space-x-4">
                            <select name="mission_icon" id="mission_icon" required class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('mission_icon') border-red-500 @enderror">
                                <option value="fas fa-bullseye" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-bullseye' ? 'selected' : '' }}>Target (fas fa-bullseye)</option>
                                <option value="fas fa-rocket" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-rocket' ? 'selected' : '' }}>Rocket (fas fa-rocket)</option>
                                <option value="fas fa-star" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-star' ? 'selected' : '' }}>Star (fas fa-star)</option>
                                <option value="fas fa-heart" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-heart' ? 'selected' : '' }}>Heart (fas fa-heart)</option>
                                <option value="fas fa-lightbulb" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-lightbulb' ? 'selected' : '' }}>Lightbulb (fas fa-lightbulb)</option>
                                <option value="fas fa-handshake" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-handshake' ? 'selected' : '' }}>Handshake (fas fa-handshake)</option>
                                <option value="fas fa-globe" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-globe' ? 'selected' : '' }}>Globe (fas fa-globe)</option>
                                <option value="fas fa-users" {{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') == 'fas fa-users' ? 'selected' : '' }}>Users (fas fa-users)</option>
                            </select>
                            <div class="text-2xl text-purple-600" id="mission_icon_preview">
                                <i class="{{ old('mission_icon', $missionVision->mission_icon ?? 'fas fa-bullseye') }}"></i>
                            </div>
                        </div>
                        @error('mission_icon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mission Description</label>
                    <textarea name="mission_description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('mission_description', $missionVision->mission_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Vision Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Our Vision</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vision Title</label>
                        <input type="text" name="vision_title" value="{{ old('vision_title', $missionVision->vision_title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vision Icon</label>
                        <div class="flex items-center space-x-4">
                            <select name="vision_icon" id="vision_icon" required class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="fas fa-rocket" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-rocket' ? 'selected' : '' }}>Rocket (fas fa-rocket)</option>
                                <option value="fas fa-eye" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-eye' ? 'selected' : '' }}>Eye (fas fa-eye)</option>
                                <option value="fas fa-star" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-star' ? 'selected' : '' }}>Star (fas fa-star)</option>
                                <option value="fas fa-mountain" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-mountain' ? 'selected' : '' }}>Mountain (fas fa-mountain)</option>
                                <option value="fas fa-compass" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-compass' ? 'selected' : '' }}>Compass (fas fa-compass)</option>
                                <option value="fas fa-lightbulb" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-lightbulb' ? 'selected' : '' }}>Lightbulb (fas fa-lightbulb)</option>
                                <option value="fas fa-globe" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-globe' ? 'selected' : '' }}>Globe (fas fa-globe)</option>
                                <option value="fas fa-trophy" {{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') == 'fas fa-trophy' ? 'selected' : '' }}>Trophy (fas fa-trophy)</option>
                            </select>
                            <div class="text-2xl text-purple-600" id="vision_icon_preview">
                                <i class="{{ old('vision_icon', $missionVision->vision_icon ?? 'fas fa-rocket') }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vision Description</label>
                    <textarea name="vision_description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('vision_description', $missionVision->vision_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Settings</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $missionVision->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Show Mission & Vision on website</label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Save Mission & Vision
            </button>
        </div>
    </form>
</div>

<script>
function saveMissionVision() {
    if (validateMissionVisionForm()) {
        document.getElementById('missionVisionForm').submit();
    }
}

function validateMissionVisionForm() {
    let isValid = true;
    let errorMessages = [];

    // Clear previous error styling
    document.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-gray-300');
    });
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validate mission title
    const missionTitle = document.querySelector('input[name="mission_title"]');
    if (!missionTitle.value.trim()) {
        showFieldError(missionTitle, 'Mission title is required');
        isValid = false;
    }

    // Validate mission description
    const missionDescription = document.querySelector('textarea[name="mission_description"]');
    if (!missionDescription.value.trim()) {
        showFieldError(missionDescription, 'Mission description is required');
        isValid = false;
    }

    // Validate vision title
    const visionTitle = document.querySelector('input[name="vision_title"]');
    if (!visionTitle.value.trim()) {
        showFieldError(visionTitle, 'Vision title is required');
        isValid = false;
    }

    // Validate vision description
    const visionDescription = document.querySelector('textarea[name="vision_description"]');
    if (!visionDescription.value.trim()) {
        showFieldError(visionDescription, 'Vision description is required');
        isValid = false;
    }

    if (!isValid) {
        showNotification('Please fix the validation errors before saving', 'error');
    }

    return isValid;
}

function showFieldError(input, message) {
    input.classList.remove('border-gray-300');
    input.classList.add('border-red-500');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-500 text-sm mt-1';
    errorDiv.textContent = message;
    
    input.parentNode.appendChild(errorDiv);
}

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Icon preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const missionIconSelect = document.getElementById('mission_icon');
    const missionIconPreview = document.getElementById('mission_icon_preview');
    const visionIconSelect = document.getElementById('vision_icon');
    const visionIconPreview = document.getElementById('vision_icon_preview');

    if (missionIconSelect && missionIconPreview) {
        missionIconSelect.addEventListener('change', function() {
            const iconClass = this.value;
            missionIconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        });
    }

    if (visionIconSelect && visionIconPreview) {
        visionIconSelect.addEventListener('change', function() {
            const iconClass = this.value;
            visionIconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        });
    }
});
</script>
@endsection
