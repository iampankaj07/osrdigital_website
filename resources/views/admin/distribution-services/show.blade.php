@extends('admin.layout')

@section('title', 'View Distribution Service')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.distribution-services.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $distributionService->title }}</h1>
                    <p class="text-gray-600 mt-2">Distribution Service Details</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.distribution-services.edit', $distributionService) }}" class="btn btn-dark">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Service
                </a>
            </div>
        </div>
    </div>

    <!-- Service Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $distributionService->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $distributionService->description }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Link URL</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ $distributionService->link }}" class="text-purple-600 hover:text-purple-700" target="_blank">
                                {{ $distributionService->link }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Icon Configuration -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Icon Configuration</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon Type</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($distributionService->icon_type) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon Preview</label>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-center h-16">
                                @if($distributionService->icon_type === 'svg')
                                    <div class="text-purple-600">
                                        {!! $distributionService->icon_html !!}
                                    </div>
                                @elseif($distributionService->icon_type === 'font-awesome')
                                    <i class="{{ $distributionService->icon_data }} text-4xl text-purple-600"></i>
                                @else
                                    <img src="{{ $distributionService->icon_data }}" alt="{{ $distributionService->title }}" class="h-16 w-auto object-contain">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon Data</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                            <code class="text-sm text-gray-800 break-all">{{ $distributionService->icon_data }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status & Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Settings</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $distributionService->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $distributionService->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $distributionService->sort_order }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $distributionService->created_at->format('M j, Y g:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $distributionService->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>

                <div class="space-y-3">
                    <a href="{{ route('admin.distribution-services.edit', $distributionService) }}" class="w-full btn btn-dark justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Service
                    </a>

                    <form action="{{ route('admin.distribution-services.destroy', $distributionService) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
