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
                                            <img src="{{ \App\Helpers\ThemeHelper::logo() }}" alt="Current Logo" class="img-fluid" style="max-height: 100px;">
                                            <p class="text-muted small mt-1">Current logo</p>
                                        </div>
                                    @endif

                                    <!-- Show selected media preview -->
                                    @if($selectedLogoMediaUrl)
                                        <div class="mb-3 p-3 border rounded bg-light text-center">
                                            <div class="mb-2">
                                                <img src="{{ $selectedLogoMediaUrl }}" class="img-fluid rounded" style="max-height: 100px;">
                                            </div>
                                            <button type="button" wire:click="clearSelectedLogoMedia" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times mr-1"></i>Remove Selected
                                            </button>
                                        </div>
                                    @endif

                                    <!-- FilePond Upload Area -->
                                    <div class="mb-3 position-relative">
                                        <x-filepond::upload
                                            wire:model="filepondLogoUploads"
                                            multiple="false"
                                            accepted-file-types="image/*"
                                            max-file-size="2MB"
                                            placeholder="Drag & Drop your image or <span class='filepond--label-action'>Browse</span>"
                                        />
                                        <div class="position-absolute" style="bottom: 8px; right: 12px; font-size: 10px; color: #999;">
                                            Powered by PQINA
                                        </div>
                                    </div>

                                    <!-- Media Library Button -->
                                    <button type="button" wire:click="openLogoMediaSelector" class="btn btn-outline-secondary btn-block mb-2">
                                        <i class="fas fa-folder-open mr-2"></i>Select from Media Library
                                    </button>

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
                                            <img src="{{ \App\Helpers\ThemeHelper::favicon() }}" alt="Current Favicon" class="img-fluid" style="max-height: 32px;">
                                            <p class="text-muted small mt-1">Current favicon</p>
                                        </div>
                                    @endif

                                    <!-- Show selected media preview -->
                                    @if($selectedFaviconMediaUrl)
                                        <div class="mb-3 p-3 border rounded bg-light text-center">
                                            <div class="mb-2">
                                                <img src="{{ $selectedFaviconMediaUrl }}" class="img-fluid rounded" style="max-height: 32px;">
                                            </div>
                                            <button type="button" wire:click="clearSelectedFaviconMedia" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times mr-1"></i>Remove Selected
                                            </button>
                                        </div>
                                    @endif

                                    <!-- FilePond Upload Area -->
                                    <div class="mb-3 position-relative">
                                        <x-filepond::upload
                                            wire:model="filepondFaviconUploads"
                                            multiple="false"
                                            accepted-file-types="image/*"
                                            max-file-size="1MB"
                                            placeholder="Drag & Drop your image or <span class='filepond--label-action'>Browse</span>"
                                        />
                                        <div class="position-absolute" style="bottom: 8px; right: 12px; font-size: 10px; color: #999;">
                                            Powered by PQINA
                                        </div>
                                    </div>

                                    <!-- Media Library Button -->
                                    <button type="button" wire:click="openFaviconMediaSelector" class="btn btn-outline-secondary btn-block mb-2">
                                        <i class="fas fa-folder-open mr-2"></i>Select from Media Library
                                    </button>

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
                    <!-- Contact Hero Section Form -->
                    <form wire:submit.prevent="saveContactHeroSection">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Contact Hero Section</h5>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_hero_title">Hero Title <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="contact_hero_title" class="form-control @error('contact_hero_title') is-invalid @enderror" placeholder="Let's Connect">
                                            @error('contact_hero_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_hero_subtitle">Hero Subtitle</label>
                                            <input type="text" wire:model="contact_hero_subtitle" class="form-control @error('contact_hero_subtitle') is-invalid @enderror" placeholder="Get In Touch">
                                            @error('contact_hero_subtitle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_hero_description">Hero Description</label>
                                    <textarea wire:model="contact_hero_description" class="form-control @error('contact_hero_description') is-invalid @enderror" rows="4" placeholder="Ready to bring your content to global audiences? Get in touch with our team and let's discuss how we can help you achieve your distribution goals."></textarea>
                                    @error('contact_hero_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fas fa-save mr-2"></i>Save Hero Section
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Contact Form Section Form -->
                    <form wire:submit.prevent="saveContactFormSection">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-envelope mr-2"></i>Contact Form Section</h5>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_form_title">Form Title <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="contact_form_title" class="form-control @error('contact_form_title') is-invalid @enderror" placeholder="Send us a Message">
                                            @error('contact_form_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="contact_form_description">Form Description</label>
                                            <textarea wire:model="contact_form_description" class="form-control @error('contact_form_description') is-invalid @enderror" rows="3" placeholder="Fill out the form below and we'll get back to you within 24 hours"></textarea>
                                            @error('contact_form_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                   <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fas fa-save mr-2"></i>Save Form Section
                                </button>
                            </div>
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

                    <!-- Company Information Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-building mr-2"></i>Company Information
                            </h5>
                            <small class="text-muted">This information will be displayed in the website footer</small>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveCompanyInfo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="footer_company_name">Company Name <span class="text-danger">*</span></label>
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

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="saveCompanyInfo">
                                        <span wire:loading.remove wire:target="saveCompanyInfo">
                                            <i class="fas fa-save mr-2"></i>Save Company Information
                                        </span>
                                        <span wire:loading wire:target="saveCompanyInfo">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Additional Settings Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cog mr-2"></i>Additional Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveAdditionalSettings">
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
                                    <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="saveAdditionalSettings">
                                        <span wire:loading.remove wire:target="saveAdditionalSettings">
                                            <i class="fas fa-save mr-2"></i>Save Additional Settings
                                        </span>
                                        <span wire:loading wire:target="saveAdditionalSettings">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Social Media Links:</strong> Social media links are managed from the "Social Media" tab above and will automatically appear in the footer.
                    </div>
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

    <!-- Media Selector Component -->
    @livewire('components.media-selector')
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', function() {
    console.log('Settings - Livewire initialized');

    // Handle media selection events
    window.addEventListener('mediaSelected', function(event) {
        @this.call('handleMediaSelection', event.detail);
    });
});
</script>
@endpush
