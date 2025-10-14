@extends('admin.layout')

@section('title', 'View Partnership Benefit')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.partnership-benefits.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Partnership Benefit Details</h1>
                <p class="text-gray-600 mt-2">View benefit information</p>
            </div>
        </div>
    </div>

    <!-- Benefit Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Benefit Information</h2>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $partnershipBenefit->title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Sort Order</label>
                    <p class="text-lg text-gray-900">{{ $partnershipBenefit->sort_order }}</p>
                </div>
            </div>

            <!-- Icon -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Icon</label>
                <div class="flex items-center space-x-4">
                    <div class="text-4xl" style="color: #EC681D">
                        <i class="{{ $partnershipBenefit->icon }}"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">{{ $partnershipBenefit->icon }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                <p class="text-gray-900">{{ $partnershipBenefit->description }}</p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $partnershipBenefit->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $partnershipBenefit->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <p class="text-gray-900">{{ $partnershipBenefit->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                    <p class="text-gray-900">{{ $partnershipBenefit->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.partnership-benefits.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Back to List
        </a>
        <a href="{{ route('admin.partnership-benefits.edit', $partnershipBenefit) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Benefit
        </a>
    </div>
</div>
@endsection




