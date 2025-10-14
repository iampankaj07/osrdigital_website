@extends('admin.layout')

@section('title', 'View Team Member')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.team-members.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Team Member Details</h1>
                <p class="text-gray-600 mt-2">View team member information</p>
            </div>
        </div>
    </div>

    <!-- Team Member Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Team Member Information</h2>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $teamMember->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Position</label>
                    <p class="text-lg text-gray-900">{{ $teamMember->position }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                    <p class="text-lg text-gray-900">{{ $teamMember->department }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Sort Order</label>
                    <p class="text-lg text-gray-900">{{ $teamMember->sort_order }}</p>
                </div>
            </div>

            <!-- Avatar -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Avatar</label>
                @if($teamMember->avatar)
                    <div class="mt-2">
                        <img src="{{ $teamMember->avatar }}" alt="{{ $teamMember->name }} avatar" class="h-24 w-24 rounded-full object-cover">
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $teamMember->avatar }}</p>
                @else
                    <p class="text-gray-500">No avatar provided</p>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    @if($teamMember->email)
                        <a href="mailto:{{ $teamMember->email }}" class="text-blue-600 hover:text-blue-900">
                            {{ $teamMember->email }}
                        </a>
                    @else
                        <p class="text-gray-500">No email provided</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Social Links</label>
                    <div class="flex space-x-4">
                        @if($teamMember->linkedin)
                            <a href="{{ $teamMember->linkedin }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        @endif
                        @if($teamMember->twitter)
                            <a href="{{ $teamMember->twitter }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        @endif
                        @if(!$teamMember->linkedin && !$teamMember->twitter)
                            <p class="text-gray-500">No social links provided</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $teamMember->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $teamMember->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <p class="text-gray-900">{{ $teamMember->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Updated At</label>
                    <p class="text-gray-900">{{ $teamMember->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.team-members.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Back to List
        </a>
        <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Team Member
        </a>
    </div>
</div>
@endsection




