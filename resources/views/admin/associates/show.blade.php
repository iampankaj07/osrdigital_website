@extends('admin.layout')

@section('title', 'View Associate')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.associates.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">View Associate</h1>
                <p class="text-gray-600 mt-2">{{ $associate->name }}</p>
            </div>
        </div>
    </div>

    <!-- Associate Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Logo and Basic Info -->
                <div>
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Logo</h3>
                        <img src="{{ $associate->logo_url }}" alt="{{ $associate->name }}" class="h-24 w-auto object-contain border border-gray-200 rounded-lg p-4">
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $associate->name }}</p>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $associate->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $associate->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $associate->sort_order }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div>

                    @if($associate->website)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <a href="{{ $associate->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $associate->website }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Created</label>
                        <p class="text-sm text-gray-900">{{ $associate->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $associate->updated_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.associates.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Back to List
                    </a>
                    <a href="{{ route('admin.associates.edit', $associate) }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200">
                        Edit Associate
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
