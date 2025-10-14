@extends('admin.layout')


@section('title', 'Legal Pages Management')

@section('content')
    @livewire('admin.legal-pages.index')
@endsection

@push('scripts')
    <!-- Quill JS Editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
@endpush

@push('styles')
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
