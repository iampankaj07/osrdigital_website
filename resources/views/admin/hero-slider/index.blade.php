@extends('admin.layout')

@section('title', 'Hero Slider Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hero Slider Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hero Slider</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hero Slides</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.hero-slider.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Slide
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($heroSliders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($heroSliders as $slider)
                                        <tr>
                                            <td>
                                                @if($slider->image)
                                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" style="width: 60px; height: 40px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $slider->title }}</td>
                                            <td>{{ Str::limit($slider->subtitle, 50) }}</td>
                                            <td>{{ $slider->sort_order }}</td>
                                            <td>
                                                <span class="badge badge-{{ $slider->is_active ? 'success' : 'danger' }}">
                                                    {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.hero-slider.show', $slider) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.hero-slider.edit', $slider) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.hero-slider.destroy', $slider) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this slide?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No hero slides found.</p>
                            <a href="{{ route('admin.hero-slider.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create First Slide
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
