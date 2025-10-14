@extends('admin.layout')

@section('title', 'View Trusted Partner')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.trusted-partners.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Trusted Partner Details</h1>
                <p class="text-gray-600 mt-2">View partner information</p>
            </div>
        </div>
    </div>

    <!-- Partner Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Partner Information</h2>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Partner Name</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $trustedPartner->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Sort Order</label>
                    <p class="text-lg text-gray-900">{{ $trustedPartner->sort_order }}</p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                <p class="text-gray-900">{{ $trustedPartner->description ?: 'No description provided' }}</p>
            </div>

            <!-- Logo & Website -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Logo</label>
                    @if($trustedPartner->logo)
                        <div class="mt-2">
                            <img src="{{ $trustedPartner->logo }}" alt="{{ $trustedPartner->name }} logo" class="h-16 w-auto object-contain">
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $trustedPartner->logo }}</p>
                    @else
                        <p class="text-gray-500">No logo provided</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Website</label>
                    @if($trustedPartner->website_url)
                        <a href="{{ $trustedPartner->website_url }}" target="_blank" class="text-blue-600 hover:text-blue-900 break-all">
                            {{ $trustedPartner->website_url }}
                        </a>
                    @else
                        <p class="text-gray-500">No website provided</p>
                    @endif
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $trustedPartner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $trustedPartner->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <p class="text-gray-900">{{ $trustedPartner->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                    <p class="text-gray-900">{{ $trustedPartner->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.trusted-partners.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Back to List
        </a>
        <a href="{{ route('admin.trusted-partners.edit', $trustedPartner) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Partner
        </a>
    </div>
</div>
@endsection




