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
                    <button wire:click="switchTab('hero')" 
                            class="nav-link {{ $activeTab === 'hero' ? 'active' : '' }}" 
                            type="button">
                        <i class="fas fa-star mr-2"></i>Hero Section
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
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" wire:model="site_logo" class="custom-file-input @error('site_logo') is-invalid @enderror" accept="image/*">
                                        <label class="custom-file-label">
                                            {{ $site_logo ? $site_logo->getClientOriginalName() : 'Choose new logo' }}
                                        </label>
                                    </div>
                                    @error('site_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Site Favicon -->
                                <div class="form-group">
                                    <label>Site Favicon</label>
                                    @if($old_site_favicon)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($old_site_favicon) }}" alt="Current Favicon" class="img-fluid" style="max-height: 32px;">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" wire:model="site_favicon" class="custom-file-input @error('site_favicon') is-invalid @enderror" accept="image/*">
                                        <label class="custom-file-label">
                                            {{ $site_favicon ? $site_favicon->getClientOriginalName() : 'Choose new favicon' }}
                                        </label>
                                    </div>
                                    @error('site_favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

                <!-- Contact Settings -->
                @if($activeTab === 'contact')
                <div class="tab-pane fade show active" id="contact" role="tabpanel">
                    <form wire:submit.prevent="saveContact">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_email">Email</label>
                                    <input type="email" wire:model="contact_email" class="form-control @error('contact_email') is-invalid @enderror">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact_phone">Phone</label>
                                    <input type="text" wire:model="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_address">Address</label>
                                    <input type="text" wire:model="contact_address" class="form-control @error('contact_address') is-invalid @enderror">
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_city">City</label>
                                            <input type="text" wire:model="contact_city" class="form-control @error('contact_city') is-invalid @enderror">
                                            @error('contact_city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_state">State</label>
                                            <input type="text" wire:model="contact_state" class="form-control @error('contact_state') is-invalid @enderror">
                                            @error('contact_state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_zip">ZIP Code</label>
                                            <input type="text" wire:model="contact_zip" class="form-control @error('contact_zip') is-invalid @enderror">
                                            @error('contact_zip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_country">Country</label>
                                            <input type="text" wire:model="contact_country" class="form-control @error('contact_country') is-invalid @enderror">
                                            @error('contact_country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Contact Settings
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
                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <textarea wire:model="footer_text" class="form-control @error('footer_text') is-invalid @enderror" rows="4" placeholder="Enter footer description or additional information"></textarea>
                            @error('footer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="footer_copyright">Copyright Text</label>
                            <input type="text" wire:model="footer_copyright" class="form-control @error('footer_copyright') is-invalid @enderror" placeholder="© 2024 Your Company Name. All rights reserved.">
                            @error('footer_copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Footer Settings
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Hero Section Settings -->
                @if($activeTab === 'hero')
                <div class="tab-pane fade show active" id="hero" role="tabpanel">
                    <form wire:submit.prevent="saveHero">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_badge_text">Badge Text</label>
                                    <input type="text" wire:model="hero_badge_text" class="form-control @error('hero_badge_text') is-invalid @enderror" placeholder="e.g., Digital Media Excellence">
                                    @error('hero_badge_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hero_main_title">Main Title</label>
                                    <input type="text" wire:model="hero_main_title" class="form-control @error('hero_main_title') is-invalid @enderror" placeholder="e.g., Bringing Stories to">
                                    @error('hero_main_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hero_highlighted_title">Highlighted Title</label>
                                    <input type="text" wire:model="hero_highlighted_title" class="form-control @error('hero_highlighted_title') is-invalid @enderror" placeholder="e.g., Global Screens">
                                    @error('hero_highlighted_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_primary_button_text">Primary Button Text</label>
                                    <input type="text" wire:model="hero_primary_button_text" class="form-control @error('hero_primary_button_text') is-invalid @enderror" placeholder="e.g., Partner With Us">
                                    @error('hero_primary_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hero_secondary_button_text">Secondary Button Text</label>
                                    <input type="text" wire:model="hero_secondary_button_text" class="form-control @error('hero_secondary_button_text') is-invalid @enderror" placeholder="e.g., Explore Portfolio">
                                    @error('hero_secondary_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hero_description">Description</label>
                            <textarea wire:model="hero_description" class="form-control @error('hero_description') is-invalid @enderror" rows="4" placeholder="Hero section description text"></textarea>
                            @error('hero_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-save mr-2"></i>Save Hero Section Settings
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
