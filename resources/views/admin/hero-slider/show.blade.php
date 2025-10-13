@extends('admin.layout')

@section('title', 'View Hero Slide')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Hero Slide</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.hero-slider.index') }}">Hero Slider</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $heroSlider->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.hero-slider.edit', $heroSlider) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.hero-slider.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Title</th>
                                    <td>{{ $heroSlider->title }}</td>
                                </tr>
                                <tr>
                                    <th>Subtitle</th>
                                    <td>{{ $heroSlider->subtitle ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $heroSlider->description ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Button Text</th>
                                    <td>{{ $heroSlider->button_text ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Button URL</th>
                                    <td>
                                        @if($heroSlider->button_url)
                                            <a href="{{ $heroSlider->button_url }}" target="_blank">{{ $heroSlider->button_url }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Secondary Button Text</th>
                                    <td>{{ $heroSlider->button_text_secondary ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Secondary Button URL</th>
                                    <td>
                                        @if($heroSlider->button_url_secondary)
                                            <a href="{{ $heroSlider->button_url_secondary }}" target="_blank">{{ $heroSlider->button_url_secondary }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $heroSlider->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $heroSlider->is_active ? 'success' : 'danger' }}">
                                            {{ $heroSlider->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $heroSlider->created_at->format('M d, Y \a\t H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $heroSlider->updated_at->format('M d, Y \a\t H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            @if($heroSlider->image)
                                <div class="text-center">
                                    <h5>Background Image</h5>
                                    <img src="{{ asset('storage/' . $heroSlider->image) }}" alt="{{ $heroSlider->title }}" class="img-fluid rounded">
                                </div>
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>No background image</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
