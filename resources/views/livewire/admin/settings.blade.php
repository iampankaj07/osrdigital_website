<div>


    <!-- Settings Tabs -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button wire:click="switchTab('general')"
                            class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}"
                            type="button">
                        <i class="fas fa-cog mr-2"></i>General
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="switchTab('contact')"
                            class="nav-link {{ $activeTab === 'contact' ? 'active' : '' }}"
                            type="button">
                        <i class="fas fa-phone mr-2"></i>Contact
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="switchTab('social')"
                            class="nav-link {{ $activeTab === 'social' ? 'active' : '' }}"
                            type="button">
                        <i class="fas fa-share-alt mr-2"></i>Social Media
                    </button>
                </li>

                <li class="nav-item">
                    <button wire:click="switchTab('footer')"
                            class="nav-link {{ $activeTab === 'footer' ? 'active' : '' }}"
                            type="button">
                        <i class="fas fa-window-maximize mr-2"></i>Footer
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <!-- General Settings -->
                @if($activeTab === 'general')
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <form wire:submit.prevent="saveGeneral">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="site_name">Site Name <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="site_name" class="form-control @error('site_name') is-invalid @enderror">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="site_title">Site Title (SEO)</label>
                                    <input type="text" wire:model="site_title" class="form-control @error('site_title') is-invalid @enderror" placeholder="Website title for search engines">
                                    @error('site_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" wire:model="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="Your company name">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea wire:model="site_description" class="form-control @error('site_description') is-invalid @enderror" rows="3" placeholder="Brief description of your website"></textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Site Logo -->
                                <div class="form-group">
                                    <label>Site Logo</label>
                                    @if($old_site_logo)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($old_site_logo) }}" alt="Current Logo" class="img-fluid" style="max-height: 100px;">
                                            <p class="text-muted small mt-1">Current logo</p>
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" wire:model="site_logo" class="custom-file-input @error('site_logo') is-invalid @enderror" accept="image/*">
                                        <label class="custom-file-label">
                                            {{ $site_logo ? $site_logo->getClientOriginalName() : 'Choose new logo' }}
                                        </label>
                                    </div>
                                    @error('site_logo')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Upload a logo image (JPEG, PNG, SVG). Max size: 2MB
                                    </small>
                                </div>

                                <!-- Site Favicon -->
                                <div class="form-group">
                                    <label>Site Favicon</label>
                                    @if($old_site_favicon)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($old_site_favicon) }}" alt="Current Favicon" class="img-fluid" style="max-height: 32px;">
                                            <p class="text-muted small mt-1">Current favicon</p>
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" wire:model="site_favicon" class="custom-file-input @error('site_favicon') is-invalid @enderror" accept="image/*">
                                        <label class="custom-file-label">
                                            {{ $site_favicon ? $site_favicon->getClientOriginalName() : 'Choose new favicon' }}
                                        </label>
                                    </div>
                                    @error('site_favicon')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Upload a favicon image (ICO, PNG). Recommended: 32x32px. Max size: 1MB
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save General Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Contact Page Settings -->
                @if($activeTab === 'contact')
                <div class="tab-pane fade show active" id="contact" role="tabpanel">
                    <form wire:submit.prevent="saveContactPage">
                        <!-- Hero Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Contact Hero Section</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_hero_title">Hero Title</label>
                                            <input type="text" wire:model="contact_hero_title" class="form-control @error('contact_hero_title') is-invalid @enderror" placeholder="Contact Us">
                                            @error('contact_hero_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_hero_subtitle">Hero Subtitle</label>
                                            <input type="text" wire:model="contact_hero_subtitle" class="form-control @error('contact_hero_subtitle') is-invalid @enderror" placeholder="Get in Touch">
                                            @error('contact_hero_subtitle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_hero_description">Hero Description</label>
                                    <textarea wire:model="contact_hero_description" class="form-control @error('contact_hero_description') is-invalid @enderror" rows="3" placeholder="Contact description..."></textarea>
                                    @error('contact_hero_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Form Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-envelope mr-2"></i>Contact Form Section</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_form_title">Form Title</label>
                                            <input type="text" wire:model="contact_form_title" class="form-control @error('contact_form_title') is-invalid @enderror" placeholder="Send us a Message">
                                            @error('contact_form_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_form_description">Form Description</label>
                                    <textarea wire:model="contact_form_description" class="form-control @error('contact_form_description') is-invalid @enderror" rows="3" placeholder="Form description..."></textarea>
                                    @error('contact_form_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Contact Page Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Social Media Settings -->
                @if($activeTab === 'social')
                <div class="tab-pane fade show active" id="social" role="tabpanel">
                    <form wire:submit.prevent="saveSocial">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook_url">Facebook URL</label>
                                    <input type="url" wire:model="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" placeholder="https://facebook.com/yourpage">
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="twitter_url">Twitter URL</label>
                                    <input type="url" wire:model="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" placeholder="https://twitter.com/yourhandle">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="instagram_url">Instagram URL</label>
                                    <input type="url" wire:model="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" placeholder="https://instagram.com/yourhandle">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin_url">LinkedIn URL</label>
                                    <input type="url" wire:model="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" placeholder="https://linkedin.com/company/yourcompany">
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="youtube_url">YouTube URL</label>
                                    <input type="url" wire:model="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" placeholder="https://youtube.com/channel/yourchannel">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Social Media Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Footer Settings -->
                @if($activeTab === 'footer')
                <div class="tab-pane fade show active" id="footer" role="tabpanel">
                    <form wire:submit.prevent="saveFooter">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Company Information</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="footer_company_name">Company Name</label>
                                    <input type="text" wire:model="footer_company_name" class="form-control @error('footer_company_name') is-invalid @enderror" placeholder="OSR Digital">
                                    @error('footer_company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="footer_email">Email</label>
                                    <input type="email" wire:model="footer_email" class="form-control @error('footer_email') is-invalid @enderror" placeholder="info@osrdigital.com">
                                    @error('footer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="footer_company_description">Company Description</label>
                            <textarea wire:model="footer_company_description" class="form-control @error('footer_company_description') is-invalid @enderror" rows="3" placeholder="Brief description of your company"></textarea>
                            @error('footer_company_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="footer_phone">Phone</label>
                                    <input type="text" wire:model="footer_phone" class="form-control @error('footer_phone') is-invalid @enderror" placeholder="+1 (555) 123-4567">
                                    @error('footer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="footer_website">Website</label>
                                    <input type="url" wire:model="footer_website" class="form-control @error('footer_website') is-invalid @enderror" placeholder="https://osrdigital.com">
                                    @error('footer_website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="footer_address">Address</label>
                            <textarea wire:model="footer_address" class="form-control @error('footer_address') is-invalid @enderror" rows="2" placeholder="Company address"></textarea>
                            @error('footer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Services -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Services</h5>
                                <p class="text-muted small">Manage the services displayed in the footer</p>
                            </div>
                        </div>

                        <div id="servicesContainer">
                            @foreach($footer_services as $index => $service)
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" wire:model="footer_services.{{ $index }}.text" class="form-control" placeholder="Service name (e.g., Digital Streaming)">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" wire:model="footer_services.{{ $index }}.icon" class="form-control" placeholder="Icon name">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" wire:click="removeService({{ $index }})" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <button type="button" wire:click="addService" class="btn btn-secondary btn-sm">
                                <i class="fas fa-plus mr-2"></i>Add Service
                            </button>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Social Media Links:</strong> Social media links are managed from the "Social Media" tab above and will automatically appear in the footer.
                        </div>

                        <hr class="my-4">

                        <!-- Quick Links -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Quick Links</h5>
                            </div>
                        </div>

                        <div id="quickLinksContainer">
                            @foreach($footer_quick_links as $index => $link)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" wire:model="footer_quick_links.{{ $index }}.title" class="form-control" placeholder="Link Title">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" wire:model="footer_quick_links.{{ $index }}.url" class="form-control" placeholder="URL">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" wire:click="removeQuickLink({{ $index }})" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <button type="button" wire:click="addQuickLink" class="btn btn-secondary btn-sm">
                                <i class="fas fa-plus mr-2"></i>Add Quick Link
                            </button>
                        </div>

                        <hr class="my-4">

                        <!-- Legacy Footer Settings (keep for compatibility) -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Additional Settings</h5>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="footer_copyright_text">Copyright Text</label>
                            <input type="text" wire:model="footer_copyright_text" class="form-control @error('footer_copyright_text') is-invalid @enderror" placeholder="© 2024 Your Company Name. All rights reserved.">
                            @error('footer_copyright_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="footer_text">Footer Text (Legacy)</label>
                            <textarea wire:model="footer_text" class="form-control @error('footer_text') is-invalid @enderror" rows="4" placeholder="Enter footer description or additional information"></textarea>
                            @error('footer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="footer_copyright">Footer Copyright (Legacy)</label>
                            <input type="text" wire:model="footer_copyright" class="form-control @error('footer_copyright') is-invalid @enderror" placeholder="© 2024 Your Company Name. All rights reserved.">
                            @error('footer_copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save mr-2"></i>Save Footer Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif




                <!-- Call to Action Settings -->
                @if($activeTab === 'cta')
                <div class="tab-pane fade show active" id="cta" role="tabpanel">
                    <form wire:submit.prevent="saveCta">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Main Content</h5>
                                <div class="form-group">
                                    <label for="cta_badge_text">Badge Text</label>
                                    <input type="text" wire:model="cta_badge_text" class="form-control @error('cta_badge_text') is-invalid @enderror" placeholder="e.g., Let's Create Together">
                                    @error('cta_badge_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_main_title">Main Title</label>
                                    <input type="text" wire:model="cta_main_title" class="form-control @error('cta_main_title') is-invalid @enderror" placeholder="e.g., Ready to Share Your">
                                    @error('cta_main_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_highlighted_title">Highlighted Title</label>
                                    <input type="text" wire:model="cta_highlighted_title" class="form-control @error('cta_highlighted_title') is-invalid @enderror" placeholder="e.g., Story?">
                                    @error('cta_highlighted_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_description">Description</label>
                                    <textarea wire:model="cta_description" class="form-control @error('cta_description') is-invalid @enderror" rows="3" placeholder="Call to action description"></textarea>
                                    @error('cta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_primary_button_text">Primary Button Text</label>
                                            <input type="text" wire:model="cta_primary_button_text" class="form-control @error('cta_primary_button_text') is-invalid @enderror" placeholder="e.g., Start Partnership">
                                            @error('cta_primary_button_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_secondary_button_text">Secondary Button Text</label>
                                            <input type="text" wire:model="cta_secondary_button_text" class="form-control @error('cta_secondary_button_text') is-invalid @enderror" placeholder="e.g., View Our Work">
                                            @error('cta_secondary_button_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Features</h5>
                                <div class="form-group">
                                    <label for="cta_feature_1_title">Feature 1 Title</label>
                                    <input type="text" wire:model="cta_feature_1_title" class="form-control @error('cta_feature_1_title') is-invalid @enderror" placeholder="e.g., Fast Partnership">
                                    @error('cta_feature_1_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_feature_1_description">Feature 1 Description</label>
                                    <textarea wire:model="cta_feature_1_description" class="form-control @error('cta_feature_1_description') is-invalid @enderror" rows="2" placeholder="Feature 1 description"></textarea>
                                    @error('cta_feature_1_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_feature_2_title">Feature 2 Title</label>
                                    <input type="text" wire:model="cta_feature_2_title" class="form-control @error('cta_feature_2_title') is-invalid @enderror" placeholder="e.g., Global Reach">
                                    @error('cta_feature_2_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_feature_2_description">Feature 2 Description</label>
                                    <textarea wire:model="cta_feature_2_description" class="form-control @error('cta_feature_2_description') is-invalid @enderror" rows="2" placeholder="Feature 2 description"></textarea>
                                    @error('cta_feature_2_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_feature_3_title">Feature 3 Title</label>
                                    <input type="text" wire:model="cta_feature_3_title" class="form-control @error('cta_feature_3_title') is-invalid @enderror" placeholder="e.g., Fair Revenue">
                                    @error('cta_feature_3_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="cta_feature_3_description">Feature 3 Description</label>
                                    <textarea wire:model="cta_feature_3_description" class="form-control @error('cta_feature_3_description') is-invalid @enderror" rows="2" placeholder="Feature 3 description"></textarea>
                                    @error('cta_feature_3_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Call to Action Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
