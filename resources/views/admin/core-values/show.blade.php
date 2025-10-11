@extends('admin.layout')

@section('title', 'View Core Value')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.core-values.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Core Value Details</h1>
                <p class="text-gray-600 mt-2">View core value information</p>
            </div>
        </div>
    </div>

    <!-- Core Value Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Core Value Information</h2>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <p class="text-lg text-gray-900">{{ $coreValue->title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <p class="text-lg text-gray-900">{{ $coreValue->sort_order }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                <div class="flex items-center space-x-4">
                    <div class="text-4xl text-purple-600">
                        <i class="{{ $coreValue->icon }}"></i>
                    </div>
                    <span class="text-sm text-gray-600">{{ $coreValue->icon }}</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <p class="text-gray-900 leading-relaxed">{{ $coreValue->description }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $coreValue->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $coreValue->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created At</label>
                    <p class="text-gray-900">{{ $coreValue->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Updated At</label>
                    <p class="text-gray-900">{{ $coreValue->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.core-values.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Back to List
        </a>
        <a href="{{ route('admin.core-values.edit', $coreValue) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Core Value
        </a>
    </div>
</div>
@endsection

