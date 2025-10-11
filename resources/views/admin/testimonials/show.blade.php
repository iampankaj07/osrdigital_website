@extends('admin.layout')

@section('title', 'Testimonial Details')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.testimonials.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Testimonial Details</h1>
                    <p class="text-gray-600 mt-2">View testimonial information and details</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Testimonial
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonial Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Testimonial Content</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Content</label>
                        <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-900 italic">"{$testimonial->content}"</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Author</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $testimonial->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $testimonial->role }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $testimonial->company }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $testimonial->project ?: 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Author Avatar -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Author Avatar</h3>
                
                <div class="text-center">
                    <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4">
                    <p class="text-sm text-gray-600">Profile picture</p>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Featured</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $testimonial->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $testimonial->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Published</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $testimonial->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $testimonial->is_published ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Sort Order</span>
                        <span class="text-sm text-gray-900">{{ $testimonial->sort_order }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Created</span>
                        <span class="text-sm text-gray-900">{{ $testimonial->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Updated</span>
                        <span class="text-sm text-gray-900">{{ $testimonial->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    <form action="{{ route('admin.testimonials.toggle-featured', $testimonial) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition-colors duration-200">
                            {{ $testimonial->is_featured ? 'Remove from Featured' : 'Add to Featured' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.testimonials.toggle-published', $testimonial) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full px-3 py-2 text-sm font-medium {{ $testimonial->is_published ? 'text-red-700 bg-red-100 hover:bg-red-200' : 'text-green-700 bg-green-100 hover:bg-green-200' }} rounded-lg transition-colors duration-200">
                            {{ $testimonial->is_published ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
