@extends('admin.layout')

@section('title', 'Associates Management')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Associates Management</h1>
                <p class="text-gray-600 mt-2">Manage our associates and partners</p>
            </div>
            <a href="{{ route('admin.associates.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Associate
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Associates Table -->
    @if($associates->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sort Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($associates as $associate)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $associate->admin_logo_url }}" alt="{{ $associate->name }}" class="h-12 w-auto object-contain">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $associate->name }}</div>
                                    @if($associate->website)
                                        <div class="text-sm text-gray-500">
                                            <a href="{{ $associate->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ $associate->website }}
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.associates.toggle-active', $associate) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ $associate->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                            {{ $associate->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $associate->sort_order }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.associates.show', $associate) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.associates.edit', $associate) }}" class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.associates.destroy', $associate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this associate?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                <i class="fas fa-handshake text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Associates Found</h3>
            <p class="text-gray-500 mb-6">Get started by adding your first associate.</p>
            <a href="{{ route('admin.associates.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add Associate
            </a>
        </div>
    @endif
</div>
@endsection
