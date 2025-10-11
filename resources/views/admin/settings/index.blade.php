@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('general')" id="general-tab" class="tab-button active py-4 px-1 border-b-2 border-purple-500 font-medium text-sm text-purple-600">
                    <i class="fas fa-cog mr-2"></i>
                    General Settings
                </button>
                <button onclick="switchTab('footer')" id="footer-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-window-maximize mr-2"></i>
                    Footer Settings
                </button>
                <button onclick="switchTab('contact')" id="contact-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Settings
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">

            <!-- General Settings Tab -->
            <div id="general-content" class="tab-content">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">General Settings</h2>
                    <button onclick="saveGeneral()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.settings.general.update') }}" id="generalForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Website Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Website Information</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Title</label>
                                    <input type="text" name="site_title" value="{{ $general['site_title'] ?? 'OSR Digital' }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-sm text-gray-500 mt-1">The main title of your website</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Tagline</label>
                                    <input type="text" name="site_tagline" value="{{ $general['site_tagline'] ?? 'Digital Media Solutions' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <p class="text-sm text-gray-500 mt-1">A short description of your website</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                                <textarea name="site_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="A comprehensive description of your website for SEO purposes">{{ $general['site_description'] ?? '' }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">This will be used in search engine results and social media sharing</p>
                            </div>
                        </div>
                    </div>

                    <!-- Website Logo -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Website Logo</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Upload</label>
                                    <div class="mt-1">
                                        <input type="file" id="logo-filepond" name="logo" accept=".png,.svg,.jpg,.jpeg" class="logo-filepond">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">PNG, SVG, JPG, JPEG up to 5MB</p>
                                    
                                    <!-- Current Logo Display -->
                                    @if(isset($general['logo']) && $general['logo'])
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Logo</label>
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url($general['logo']) }}" alt="Current Logo" class="h-16 w-auto object-contain border border-gray-200 rounded">
                                                <button type="button" onclick="removeLogo()" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Remove Logo
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Favicon</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon Upload</label>
                                    <div class="mt-1">
                                        <input type="file" id="favicon-filepond" name="favicon" accept=".png,.svg,.ico" class="favicon-filepond">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">PNG, SVG, ICO up to 1MB (recommended: 32x32px)</p>
                                    
                                    <!-- Current Favicon Display -->
                                    @if(isset($general['favicon']) && $general['favicon'])
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Favicon</label>
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url($general['favicon']) }}" alt="Current Favicon" class="h-8 w-8 object-contain border border-gray-200 rounded">
                                                <button type="button" onclick="removeFavicon()" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Remove Favicon
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Settings Tab -->
            <div id="footer-content" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Footer Settings</h2>
                    <button onclick="saveFooter()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.settings.footer.update') }}" id="footerForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Company Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Company Information</h3>
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
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Social Media Links</h3>
                        </div>
                        <div class="p-6">
                            <div id="socialLinks">
                                @if($footer && $footer->social_links && is_array($footer->social_links))
                                    @php
                                        $socialLinks = $footer->social_links;
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
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                        </div>
                        <div class="p-6">
                            <div id="quickLinks">
                                @if($footer && $footer->quick_links && is_array($footer->quick_links))
                                    @php
                                        $quickLinks = $footer->quick_links;
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
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Copyright</h3>
                        </div>
                        <div class="p-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Copyright Text</label>
                                <input type="text" name="copyright_text" value="{{ $footer->copyright_text ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Contact Settings Tab -->
            <div id="contact-content" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Contact Settings</h2>
                    <button onclick="saveContact()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.settings.contact.update') }}" id="contactForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Contact Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Contact Details</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Email</label>
                                    <input type="email" name="primary_email" value="info@osrdigital.com" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Support Email</label>
                                    <input type="email" name="support_email" value="support@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" value="+1 (123) 456-7890" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Toll Free</label>
                                    <input type="tel" name="toll_free" value="1-800-OSR-DIGITAL" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">123 Digital Street
Tech City, TC 12345
United States</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Office Locations -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Office Locations</h3>
                        </div>
                        <div class="p-6">
                            <div id="officeLocations">
                                <div class="flex items-center space-x-4 mb-4 office-location-item">
                                    <div class="flex-1">
                                        <input type="text" name="office_locations[0][name]" placeholder="Office Name" value="Headquarters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="office_locations[0][address]" placeholder="Address" value="123 Digital Street, Tech City" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <div class="w-32">
                                        <input type="tel" name="office_locations[0][phone]" placeholder="Phone" value="+1 (123) 456-7890" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    </div>
                                    <button type="button" onclick="removeOfficeLocation(this)" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addOfficeLocation()" class="mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
                                <i class="fas fa-plus mr-1"></i>
                                Add Office Location
                            </button>
                        </div>
                    </div>

                    <!-- Contact Forms -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Contact Forms</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">General Contact Email</label>
                                <input type="email" name="general_contact_email" value="contact@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sales Email</label>
                                <input type="email" name="sales_email" value="sales@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Press Email</label>
                                <input type="email" name="press_email" value="press@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Careers Email</label>
                                <input type="email" name="careers_email" value="careers@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Emergency Contact</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Phone</label>
                                    <input type="tel" name="emergency_phone" value="+1 (123) 456-7890" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Email</label>
                                    <input type="email" name="emergency_email" value="emergency@osrdigital.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Instructions</label>
                                <textarea name="emergency_instructions" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">For urgent matters outside business hours, please call our emergency line or send an email. We will respond within 2 hours.</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
// Tab functionality
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-purple-500', 'text-purple-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-purple-500', 'text-purple-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}


// General functions
function saveGeneral() {
    if (validateGeneralForm()) {
        document.getElementById('generalForm').submit();
    }
}

function validateGeneralForm() {
    let isValid = true;
    
    // Clear previous error styling
    document.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-gray-300');
    });
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validate site title (required)
    const siteTitle = document.querySelector('input[name="site_title"]');
    if (!siteTitle.value.trim()) {
        showFieldError(siteTitle, 'Site title is required');
        isValid = false;
    }

    if (!isValid) {
        showNotification('Please fix the validation errors before saving', 'error');
    }

    return isValid;
}

function handleLogoUpload(input) {
    const file = input.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Please select a valid image file (PNG, SVG, JPG, JPEG)', 'error');
            input.value = '';
            return;
        }
        
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            showNotification('File size must be less than 5MB', 'error');
            input.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const uploadArea = document.getElementById('logo-upload-area');
            uploadArea.innerHTML = `
                <div class="text-center">
                    <img src="${e.target.result}" alt="Logo Preview" class="mx-auto h-16 w-auto object-contain border border-gray-200 rounded">
                    <p class="text-sm text-gray-600 mt-2">${file.name}</p>
                    <button type="button" onclick="clearLogoUpload()" class="text-red-600 hover:text-red-800 text-sm mt-1">
                        <i class="fas fa-times mr-1"></i>
                        Remove
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function clearLogoUpload() {
    const input = document.getElementById('logo');
    input.value = '';
    const uploadArea = document.getElementById('logo-upload-area');
    uploadArea.innerHTML = `
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                    <span>Upload a logo</span>
                    <input id="logo" name="logo" type="file" accept=".png,.svg,.jpg,.jpeg" class="sr-only" onchange="handleLogoUpload(this)">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, SVG, JPG, JPEG up to 5MB</p>
        </div>
    `;
}

function handleFaviconUpload(input) {
    const file = input.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['image/png', 'image/svg+xml', 'image/x-icon'];
        if (!allowedTypes.includes(file.type)) {
            showNotification('Please select a valid favicon file (PNG, SVG, ICO)', 'error');
            input.value = '';
            return;
        }
        
        // Validate file size (1MB max)
        if (file.size > 1 * 1024 * 1024) {
            showNotification('File size must be less than 1MB', 'error');
            input.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const uploadArea = document.getElementById('favicon-upload-area');
            uploadArea.innerHTML = `
                <div class="text-center">
                    <img src="${e.target.result}" alt="Favicon Preview" class="mx-auto h-8 w-8 object-contain border border-gray-200 rounded">
                    <p class="text-sm text-gray-600 mt-2">${file.name}</p>
                    <button type="button" onclick="clearFaviconUpload()" class="text-red-600 hover:text-red-800 text-sm mt-1">
                        <i class="fas fa-times mr-1"></i>
                        Remove
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function clearFaviconUpload() {
    const input = document.getElementById('favicon');
    input.value = '';
    const uploadArea = document.getElementById('favicon-upload-area');
    uploadArea.innerHTML = `
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="favicon" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                    <span>Upload a favicon</span>
                    <input id="favicon" name="favicon" type="file" accept=".png,.svg,.ico" class="sr-only" onchange="handleFaviconUpload(this)">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, SVG, ICO up to 1MB (recommended: 32x32px)</p>
        </div>
    `;
}

function removeLogo() {
    if (confirm('Are you sure you want to remove the current logo?')) {
        // Add hidden input to indicate logo removal
        const form = document.getElementById('generalForm');
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_logo';
        removeInput.value = '1';
        form.appendChild(removeInput);
        
        // Hide the current logo display
        const logoDisplay = document.querySelector('[onclick="removeLogo()"]').closest('.mt-4');
        if (logoDisplay) {
            logoDisplay.style.display = 'none';
        }
    }
}

function removeFavicon() {
    if (confirm('Are you sure you want to remove the current favicon?')) {
        // Add hidden input to indicate favicon removal
        const form = document.getElementById('generalForm');
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_favicon';
        removeInput.value = '1';
        form.appendChild(removeInput);
        
        // Hide the current favicon display
        const faviconDisplay = document.querySelector('[onclick="removeFavicon()"]').closest('.mt-4');
        if (faviconDisplay) {
            faviconDisplay.style.display = 'none';
        }
    }
}

// Footer functions
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

// Contact functions
let officeLocationIndex = 1;

function addOfficeLocation() {
    const container = document.getElementById('officeLocations');
    const newLocation = document.createElement('div');
    newLocation.className = 'flex items-center space-x-4 mb-4 office-location-item';
    newLocation.innerHTML = `
        <div class="flex-1">
            <input type="text" name="office_locations[${officeLocationIndex}][name]" placeholder="Office Name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        <div class="flex-1">
            <input type="text" name="office_locations[${officeLocationIndex}][address]" placeholder="Address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        <div class="w-32">
            <input type="tel" name="office_locations[${officeLocationIndex}][phone]" placeholder="Phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        <button type="button" onclick="removeOfficeLocation(this)" class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newLocation);
    officeLocationIndex++;
}

function removeOfficeLocation(button) {
    button.parentElement.remove();
}

function saveContact() {
    document.getElementById('contactForm').submit();
}

// Initialize FilePond for logo and favicon uploads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize FilePond for logo upload
    const logoPond = FilePond.create(document.querySelector('.logo-filepond'), {
        name: 'logo',
        acceptedFileTypes: ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'],
        maxFileSize: '2MB',
        allowRevert: false,
        allowRemove: true,
        allowReplace: true,
        labelIdle: 'Drag & Drop your logo or <span class="filepond--label-action">Browse</span>',
        labelInvalidType: 'Invalid file type. Please upload PNG, SVG, JPG, or JPEG.',
        labelFileSizeTooBig: 'File is too large. Maximum size is 2MB.',
        allowImagePreview: true,
        imagePreviewHeight: 200,
        server: {
            process: {
                url: '/upload/general-logo',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                withCredentials: true,
                onload: (response) => {
                    const result = JSON.parse(response);
                    if (result.success) {
                        console.log('Logo uploaded successfully:', result);
                        // Update the form with the uploaded file path
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'logo_path';
                        hiddenInput.value = result.url;
                        document.getElementById('generalForm').appendChild(hiddenInput);
                    }
                    return response;
                },
                onerror: (response) => {
                    console.error('Logo upload failed:', response);
                    console.error('Response type:', typeof response);
                    console.error('Response content:', response);
                    showNotification('Logo upload failed. Please try again.', 'error');
                    return response;
                }
            }
        }
    });

    // Load existing logo if available
    @if(isset($general['logo']) && $general['logo'])
        const existingLogoUrl = '{{ Storage::url($general['logo']) }}';
        if (existingLogoUrl && !existingLogoUrl.includes('via.placeholder.com')) {
            logoPond.addFile(existingLogoUrl, {
                type: 'image/*',
                metadata: {
                    poster: existingLogoUrl
                }
            });
        }
    @endif

    // Initialize FilePond for favicon upload
    const faviconPond = FilePond.create(document.querySelector('.favicon-filepond'), {
        name: 'favicon',
        acceptedFileTypes: ['image/png', 'image/svg+xml', 'image/x-icon'],
        maxFileSize: '2MB',
        allowRevert: false,
        allowRemove: true,
        allowReplace: true,
        labelIdle: 'Drag & Drop your favicon or <span class="filepond--label-action">Browse</span>',
        labelInvalidType: 'Invalid file type. Please upload PNG, SVG, or ICO.',
        labelFileSizeTooBig: 'File is too large. Maximum size is 2MB.',
        allowImagePreview: true,
        imagePreviewHeight: 100,
        server: {
            process: {
                url: '/upload/general-favicon',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                withCredentials: true,
                onload: (response) => {
                    const result = JSON.parse(response);
                    if (result.success) {
                        console.log('Favicon uploaded successfully:', result);
                        // Update the form with the uploaded file path
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'favicon_path';
                        hiddenInput.value = result.url;
                        document.getElementById('generalForm').appendChild(hiddenInput);
                    }
                    return response;
                },
                onerror: (response) => {
                    console.error('Favicon upload failed:', response);
                    console.error('Response type:', typeof response);
                    console.error('Response content:', response);
                    showNotification('Favicon upload failed. Please try again.', 'error');
                    return response;
                }
            }
        }
    });

    // Load existing favicon if available
    @if(isset($general['favicon']) && $general['favicon'])
        const existingFaviconUrl = '{{ Storage::url($general['favicon']) }}';
        if (existingFaviconUrl && !existingFaviconUrl.includes('via.placeholder.com')) {
            faviconPond.addFile(existingFaviconUrl, {
                type: 'image/*',
                metadata: {
                    poster: existingFaviconUrl
                }
            });
        }
    @endif
});
</script>
@endsection