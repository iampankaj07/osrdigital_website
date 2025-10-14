@extends('admin.layout')
@section('title', 'Hero Slider Management')

@section('content')
    @livewire('admin.hero-sliders.index')
@endsection

@push('styles')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<style>
.inline-edit-form {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-left: 4px solid #007bff;
}

.filepond--root {
    max-height: 120px;
}

.filepond--drop-label {
    height: auto;
    min-height: 80px;
}

.btn-group .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

<script>
    // Register FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginFileValidateSize
    );

    // Initialize FilePond when Livewire loads
    document.addEventListener('livewire:initialized', function () {
        initializeFilePond();
    });

    document.addEventListener('livewire:navigated', function () {
        initializeFilePond();
    });

    function initializeFilePond() {
        const filepondElements = document.querySelectorAll('.filepond');
        filepondElements.forEach(element => {
            if (!element.filepond) {
                FilePond.create(element);
            }
        });
    }
</script>
@endpush
