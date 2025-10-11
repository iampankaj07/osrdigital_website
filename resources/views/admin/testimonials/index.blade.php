@extends('admin.layout')

@section('title', 'Testimonials')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Testimonials</h1>
                <p class="text-gray-600 mt-2">Manage partner testimonials and quotes</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add Testimonial
            </a>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Testimonial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <p class="text-sm text-gray-900 line-clamp-2">{{ Str::limit($testimonial->content, 100) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $testimonial->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $testimonial->role }}</div>
                                        <div class="text-xs text-gray-400">{{ $testimonial->company }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($testimonial->project)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $testimonial->project }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    @if($testimonial->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    @endif
                                    @if($testimonial->is_published)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-eye mr-1"></i>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-eye-slash mr-1"></i>
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.testimonials.show', $testimonial) }}" class="text-gray-400 hover:text-gray-600" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.testimonials.toggle-featured', $testimonial) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="{{ $testimonial->is_featured ? 'Remove from featured' : 'Add to featured' }}">
                                            <i class="fas fa-star{{ $testimonial->is_featured ? '' : '-o' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testimonials.toggle-published', $testimonial) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="{{ $testimonial->is_published ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-eye{{ $testimonial->is_published ? '' : '-slash' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-quote-left text-4xl mb-4"></i>
                                <p class="text-lg">No testimonials found</p>
                                <p class="text-sm">Get started by adding your first testimonial.</p>
                                <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center px-4 py-2 mt-4 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Your First Testimonial
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
