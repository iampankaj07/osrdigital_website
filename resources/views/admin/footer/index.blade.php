@extends('admin.layout')

@section('title', 'Footer Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Footer Settings</h1>
        <button onclick="saveFooter()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-save mr-2"></i>
            Save Changes
        </button>
    </div>

    <form method="POST" action="{{ route('admin.footer.update') }}" id="footerForm">
        @csrf
        @method('PUT')
        
        <!-- Company Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Company Information</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                        <input type="text" name="company_name" value="{{ $footer->company_name ?? '' }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $footer->email ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Description</label>
                    <textarea name="company_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $footer->company_description ?? '' }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ $footer->phone ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="url" name="website" value="{{ $footer->website ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="address" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $footer->address ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Social Links -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Social Media Links</h2>
            </div>
            <div class="p-6">
                <div id="socialLinks">
                    @if($footer && $footer->social_links && is_array($footer->social_links))
                        @php
                            $socialLinks = $footer->social_links;
                            // Convert associative array to indexed array if needed
                            if (array_keys($socialLinks) !== range(0, count($socialLinks) - 1)) {
                                $socialLinks = array_values($socialLinks);
                            }
                        @endphp
                        @foreach($socialLinks as $index => $link)
                            <div class="flex items-center space-x-4 mb-4 social-link-item">
                                <div class="w-32">
                                    <select name="social_links[{{ $index }}][platform]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="facebook" {{ (is_array($link) && isset($link['platform']) && $link['platform'] === 'facebook') || (!is_array($link) && $index === 'facebook') ? 'selected' : '' }}>Facebook</option>
                                        <option value="twitter" {{ (is_array($link) && isset($link['platform']) && $link['platform'] === 'twitter') || (!is_array($link) && $index === 'twitter') ? 'selected' : '' }}>Twitter</option>
                                        <option value="linkedin" {{ (is_array($link) && isset($link['platform']) && $link['platform'] === 'linkedin') || (!is_array($link) && $index === 'linkedin') ? 'selected' : '' }}>LinkedIn</option>
                                        <option value="instagram" {{ (is_array($link) && isset($link['platform']) && $link['platform'] === 'instagram') || (!is_array($link) && $index === 'instagram') ? 'selected' : '' }}>Instagram</option>
                                        <option value="youtube" {{ (is_array($link) && isset($link['platform']) && $link['platform'] === 'youtube') || (!is_array($link) && $index === 'youtube') ? 'selected' : '' }}>YouTube</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <input type="url" name="social_links[{{ $index }}][url]" value="{{ is_array($link) ? ($link['url'] ?? '') : $link }}" placeholder="https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <button type="button" onclick="removeSocialLink(this)" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center space-x-4 mb-4 social-link-item">
                            <div class="w-32">
                                <select name="social_links[0][platform]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="youtube">YouTube</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <input type="url" name="social_links[0][url]" placeholder="https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <button type="button" onclick="removeSocialLink(this)" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addSocialLink()" class="mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i>
                    Add Social Link
                </button>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Quick Links</h2>
            </div>
            <div class="p-6">
                <div id="quickLinks">
                    @if($footer && $footer->quick_links && is_array($footer->quick_links))
                        @php
                            $quickLinks = $footer->quick_links;
                            // Convert associative array to indexed array if needed
                            if (array_keys($quickLinks) !== range(0, count($quickLinks) - 1)) {
                                $quickLinks = array_values($quickLinks);
                            }
                        @endphp
                        @foreach($quickLinks as $index => $link)
                            <div class="flex items-center space-x-4 mb-4 quick-link-item">
                                <div class="flex-1">
                                    <input type="text" name="quick_links[{{ $index }}][title]" value="{{ is_array($link) ? ($link['title'] ?? '') : '' }}" placeholder="Link Title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
                                </div>
                                <div class="flex-1">
                                    <input type="url" name="quick_links[{{ $index }}][url]" value="{{ is_array($link) ? ($link['url'] ?? '') : '' }}" placeholder="/page-url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
                                </div>
                                <button type="button" onclick="removeQuickLink(this)" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center space-x-4 mb-4 quick-link-item">
                            <div class="flex-1">
                                <input type="text" name="quick_links[0][title]" placeholder="Link Title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
                            </div>
                            <div class="flex-1">
                                <input type="url" name="quick_links[0][url]" placeholder="/page-url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
                            </div>
                            <button type="button" onclick="removeQuickLink(this)" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addQuickLink()" class="mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i>
                    Add Quick Link
                </button>
            </div>
        </div>


        <!-- Copyright -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Copyright</h2>
            </div>
            <div class="p-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Copyright Text</label>
                    <input type="text" name="copyright_text" value="{{ $footer->copyright_text ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Save Footer Settings
            </button>
        </div>
    </form>
</div>

<script>
let socialLinkIndex = {{ $footer && $footer->social_links && is_array($footer->social_links) ? count($footer->social_links) : 1 }};
let quickLinkIndex = {{ $footer && $footer->quick_links && is_array($footer->quick_links) ? count($footer->quick_links) : 1 }};

function addSocialLink() {
    const container = document.getElementById('socialLinks');
    const newLink = document.createElement('div');
    newLink.className = 'flex items-center space-x-4 mb-4 social-link-item';
    newLink.innerHTML = `
        <div class="w-32">
            <select name="social_links[${socialLinkIndex}][platform]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="facebook">Facebook</option>
                <option value="twitter">Twitter</option>
                <option value="linkedin">LinkedIn</option>
                <option value="instagram">Instagram</option>
                <option value="youtube">YouTube</option>
            </select>
        </div>
        <div class="flex-1">
            <input type="url" name="social_links[${socialLinkIndex}][url]" placeholder="https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        <button type="button" onclick="removeSocialLink(this)" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newLink);
    socialLinkIndex++;
}

function removeSocialLink(button) {
    button.parentElement.remove();
}

function addQuickLink() {
    const container = document.getElementById('quickLinks');
    const newLink = document.createElement('div');
    newLink.className = 'flex items-center space-x-4 mb-4 quick-link-item';
    newLink.innerHTML = `
        <div class="flex-1">
            <input type="text" name="quick_links[${quickLinkIndex}][title]" placeholder="Link Title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
        </div>
        <div class="flex-1">
            <input type="url" name="quick_links[${quickLinkIndex}][url]" placeholder="/page-url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" onblur="validateQuickLinkField(this)">
        </div>
        <button type="button" onclick="removeQuickLink(this)" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newLink);
    quickLinkIndex++;
}

function removeQuickLink(button) {
    button.parentElement.remove();
}

function saveFooter() {
    if (validateFooterForm()) {
        document.getElementById('footerForm').submit();
    }
}

function validateFooterForm() {
    let isValid = true;
    let errorMessages = [];

    // Clear previous error styling
    document.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-gray-300');
    });
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validate company name (required)
    const companyName = document.querySelector('input[name="company_name"]');
    if (!companyName.value.trim()) {
        showFieldError(companyName, 'Company name is required');
        isValid = false;
    }

    // Validate quick links
    const quickLinkItems = document.querySelectorAll('.quick-link-item');
    quickLinkItems.forEach((item, index) => {
        const titleInput = item.querySelector('input[name*="[title]"]');
        const urlInput = item.querySelector('input[name*="[url]"]');
        
        const title = titleInput.value.trim();
        const url = urlInput.value.trim();
        
        // If either field has content, both are required
        if (title || url) {
            if (!title) {
                showFieldError(titleInput, `Quick link ${index + 1} title is required`);
                isValid = false;
            }
            if (!url) {
                showFieldError(urlInput, `Quick link ${index + 1} URL is required`);
                isValid = false;
            } else if (!isValidUrl(url)) {
                showFieldError(urlInput, `Quick link ${index + 1} URL must start with / or http:// or https://`);
                isValid = false;
            }
        }
    });

    // Validate social links
    const socialLinkItems = document.querySelectorAll('.social-link-item');
    socialLinkItems.forEach((item, index) => {
        const urlInput = item.querySelector('input[name*="[url]"]');
        const url = urlInput.value.trim();
        
        if (url && !isValidUrl(url)) {
            showFieldError(urlInput, `Social link ${index + 1} must be a valid URL`);
            isValid = false;
        }
    });

    // Validate email if provided
    const emailInput = document.querySelector('input[name="email"]');
    if (emailInput.value.trim() && !isValidEmail(emailInput.value.trim())) {
        showFieldError(emailInput, 'Please enter a valid email address');
        isValid = false;
    }

    // Validate website if provided
    const websiteInput = document.querySelector('input[name="website"]');
    if (websiteInput.value.trim() && !isValidUrl(websiteInput.value.trim())) {
        showFieldError(websiteInput, 'Please enter a valid website URL');
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

function isValidUrl(string) {
    // Allow relative URLs starting with / or absolute URLs starting with http:// or https://
    const urlPattern = /^(\/|https?:\/\/)/;
    return urlPattern.test(string);
}

function isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
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

function validateQuickLinkField(input) {
    const value = input.value.trim();
    const isUrlField = input.name.includes('[url]');
    const isTitleField = input.name.includes('[title]');
    
    // Clear previous error styling
    input.classList.remove('border-red-500');
    input.classList.add('border-gray-300');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // If field is empty, no validation needed
    if (!value) {
        return;
    }
    
    let isValid = true;
    let errorMessage = '';
    
    if (isUrlField) {
        if (!isValidUrl(value)) {
            isValid = false;
            errorMessage = 'URL must start with / or http:// or https://';
        }
    } else if (isTitleField) {
        if (value.length > 255) {
            isValid = false;
            errorMessage = 'Title must be less than 255 characters';
        }
    }
    
    if (!isValid) {
        input.classList.remove('border-gray-300');
        input.classList.add('border-red-500');
        showFieldError(input, errorMessage);
    }
}
</script>
@endsection