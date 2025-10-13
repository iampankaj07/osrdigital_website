<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Business Pages</h1>
            <p class="text-gray-600">Manage your business page content</p>
        </div>
        <button wire:click="startCreating"
                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Create Business Page
        </button>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1">
                <input type="text"
                       wire:model.live="search"
                       placeholder="Search business pages..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div class="flex items-center space-x-4">
                <select wire:model.live="perPage"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Create/Edit Form -->
    @if ($isCreating || $editingId)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">
                {{ $isCreating ? 'Create Business Page' : 'Edit Business Page' }}
            </h2>

            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text"
                               id="title"
                               wire:model="form.title"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('form.title') border-red-500 @enderror">
                        @error('form.title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text"
                               id="subtitle"
                               wire:model="form.subtitle"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('form.subtitle') border-red-500 @enderror">
                        @error('form.subtitle') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description"
                              wire:model="form.description"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('form.description') border-red-500 @enderror"></textarea>
                    @error('form.description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- SEO Meta -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-4">SEO Meta Information</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                            <input type="text"
                                   id="meta_title"
                                   wire:model="form.meta_title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea id="meta_description"
                                      wire:model="form.meta_description"
                                      rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Hero Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-4">Hero Section</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">Hero Image</label>
                            <input type="file"
                                   wire:model="heroImageUpload"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            @if ($form['hero_image'])
                                <p class="text-sm text-gray-600 mt-1">Current: {{ $form['hero_image'] }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="hero_video" class="block text-sm font-medium text-gray-700 mb-2">Hero Video URL</label>
                            <input type="url"
                                   id="hero_video"
                                   wire:model="form.hero_video"
                                   placeholder="https://..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Content Sections -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-4">Content Sections</h3>

                    <!-- Existing sections -->
                    @if (!empty($form['content_sections']))
                        <div class="space-y-3 mb-4">
                            @foreach ($form['content_sections'] as $index => $section)
                                <div class="bg-white p-3 rounded border">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium">{{ $section['title'] ?? 'Untitled' }}</h4>
                                            <p class="text-sm text-gray-600">{{ Str::limit($section['content'] ?? '', 100) }}</p>
                                        </div>
                                        <button type="button"
                                                wire:click="removeContentSection({{ $index }})"
                                                class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Add new section -->
                    <div class="border-t pt-4">
                        <h4 class="font-medium mb-3">Add New Section</h4>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <select wire:model="newSection.type" class="px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="text">Text</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                            <input type="text"
                                   wire:model="newSection.title"
                                   placeholder="Section title..."
                                   class="px-3 py-2 border border-gray-300 rounded-lg">
                            <button type="button"
                                    wire:click="addContentSection"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Add Section
                            </button>
                        </div>
                        <textarea wire:model="newSection.content"
                                  placeholder="Section content..."
                                  rows="2"
                                  class="w-full mt-2 px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                </div>

                <!-- Settings -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               wire:model="form.is_active"
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                        <input type="number"
                               id="sort_order"
                               wire:model="form.sort_order"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <button type="button"
                            wire:click="cancelEditing"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        {{ $isCreating ? 'Create' : 'Update' }} Business Page
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Business Pages List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('title')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Title
                            @if ($sortField === 'title')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtitle
                        </th>
                        <th wire:click="sortBy('is_active')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Status
                            @if ($sortField === 'is_active')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('sort_order')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Order
                            @if ($sortField === 'sort_order')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('updated_at')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Updated
                            @if ($sortField === 'updated_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($businessPages as $businessPage)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $businessPage->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ Str::limit($businessPage->subtitle, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $businessPage->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $businessPage->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $businessPage->sort_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $businessPage->updated_at->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="startEditing({{ $businessPage->id }})"
                                        class="text-purple-600 hover:text-purple-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $businessPage->id }})"
                                        onclick="confirm('Are you sure you want to delete this business page?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center space-y-3">
                                    <i class="fas fa-building text-4xl text-gray-300"></i>
                                    <p class="text-lg">No business pages found</p>
                                    <p class="text-sm">{{ $search ? 'Try adjusting your search criteria.' : 'Create your first business page to get started.' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($businessPages->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $businessPages->links() }}
            </div>
        @endif
    </div>
</div>
