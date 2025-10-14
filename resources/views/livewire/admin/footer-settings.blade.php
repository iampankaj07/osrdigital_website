<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Footer Settings</h1>
        <button wire:click="save" class="btn btn-dark" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="fas fa-save mr-2"></i>
                Save Changes
            </span>
            <span wire:loading>
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Saving...
            </span>
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Company Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Company Information</h2>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                    <input type="text" wire:model="company_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('company_name') border-red-500 @enderror">
                    @error('company_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Company Description</label>
                <textarea wire:model="company_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('company_description') border-red-500 @enderror"></textarea>
                @error('company_description')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="text" wire:model="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="url" wire:model="website" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('website') border-red-500 @enderror">
                    @error('website')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea wire:model="address" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('address') border-red-500 @enderror"></textarea>
                @error('address')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Social Links -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Social Media Links</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($social_links as $index => $link)
                    <div class="flex items-center space-x-4" wire:key="social-{{ $index }}">
                        <div class="w-32">
                            <select wire:model="social_links.{{ $index }}.platform" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('social_links.'.$index.'.platform') border-red-500 @enderror">
                                <option value="facebook">Facebook</option>
                                <option value="twitter">Twitter</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="instagram">Instagram</option>
                                <option value="youtube">YouTube</option>
                                <option value="tiktok">TikTok</option>
                            </select>
                            @error('social_links.'.$index.'.platform')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <input type="url" wire:model="social_links.{{ $index }}.url" placeholder="https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('social_links.'.$index.'.url') border-red-500 @enderror">
                            @error('social_links.'.$index.'.url')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" wire:click="removeSocialLink({{ $index }})" class="text-red-600 hover:text-red-800 p-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" wire:click="addSocialLink" class="mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
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
            <div class="space-y-4">
                @foreach($quick_links as $index => $link)
                    <div class="flex items-center space-x-4" wire:key="quick-{{ $index }}">
                        <div class="flex-1">
                            <input type="text" wire:model="quick_links.{{ $index }}.title" placeholder="Link Title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('quick_links.'.$index.'.title') border-red-500 @enderror">
                            @error('quick_links.'.$index.'.title')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <input type="text" wire:model="quick_links.{{ $index }}.url" placeholder="/page-url or https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('quick_links.'.$index.'.url') border-red-500 @enderror">
                            @error('quick_links.'.$index.'.url')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" wire:click="removeQuickLink({{ $index }})" class="text-red-600 hover:text-red-800 p-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" wire:click="addQuickLink" class="mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
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
                <input type="text" wire:model="copyright_text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('copyright_text') border-red-500 @enderror">
                @error('copyright_text')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="button" wire:click="save" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors" wire:loading.attr="disabled">
            <span wire:loading.remove>
                <i class="fas fa-save mr-2"></i>
                Save Footer Settings
            </span>
            <span wire:loading>
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Saving...
            </span>
        </button>
    </div>
</div>
