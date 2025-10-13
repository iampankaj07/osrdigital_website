@php
$isCustomPlaceholder = isset($placeholder);
@endphp

@props([
    'multiple' => false,
    'required' => false,
    'disabled' => false,
    'placeholder' => __('Drag & Drop your files or <span class="filepond--label-action"> Browse </span>'),
])

@php
if (! $wireModelAttribute = $attributes->whereStartsWith('wire:model')->first()) {
    throw new Exception("You must wire:model to the filepond input.");
}

$pondProperties = $attributes->except([
    'class',
    'placeholder',
    'required',
    'disabled',
    'multiple',
    'wire:model',
]);

// convert keys from kebab-case to camelCase
$pondProperties = collect($pondProperties)
    ->mapWithKeys(fn ($value, $key) => [Illuminate\Support\Str::camel($key) => $value])
    ->toArray();

$pondLocalizations = __('livewire-filepond::filepond');
$componentId = 'filepond_' . uniqid();
@endphp

<div id="{{ $componentId }}" class="{{ $attributes->get('class') }}" wire:ignore x-cloak>
    <input type="file" x-ref="fileInput">
</div>

<script>
document.addEventListener('livewire:initialized', function() {
    console.log('Simple FilePond initializing for {{ $componentId }}...');

    // Initialize when both Livewire and LivewireFilePond are ready
    function initFilePond() {
        const container = document.getElementById('{{ $componentId }}');
        const input = container.querySelector('input[type="file"]');

        if (!container || !input) {
            console.error('FilePond container or input not found');
            return;
        }

        if (typeof LivewireFilePond === 'undefined') {
            console.log('LivewireFilePond not ready, retrying in 100ms...');
            setTimeout(initFilePond, 100);
            return;
        }

        if (typeof @this === 'undefined') {
            console.log('Livewire component not ready, retrying in 100ms...');
            setTimeout(initFilePond, 100);
            return;
        }

        console.log('Creating FilePond instance...');
        const pond = LivewireFilePond.create(input);

        // Configure FilePond
        pond.setOptions({
            allowMultiple: @js($multiple),
            server: {
                process: async (fieldName, file, metadata, load, error, progress) => {
                    console.log('FilePond: Processing file', file.name);
                    try {
                        await @this.upload('{{ $wireModelAttribute }}', file, (response) => {
                            console.log('FilePond: Upload successful', response);
                            load(response);
                        }, error, (event) => {
                            progress(event.detail.progress, event.detail.progress, 100);
                        });
                    } catch (e) {
                        console.error('FilePond: Upload error', e);
                        error('Upload failed');
                    }
                },
                revert: async (filename, load) => {
                    try {
                        await @this.revert('{{ $wireModelAttribute }}', filename, load);
                        console.log('FilePond: Revert successful');
                    } catch (e) {
                        console.error('FilePond: Revert error', e);
                    }
                },
                remove: async (file, load) => {
                    try {
                        await @this.remove('{{ $wireModelAttribute }}', file.name);
                        load();
                        console.log('FilePond: Remove successful');
                    } catch (e) {
                        console.error('FilePond: Remove error', e);
                    }
                },
            },
            required: @js($required),
            disabled: @js($disabled),
            @if($isCustomPlaceholder)
            labelIdle: @js($placeholder)
            @endif
        });

        // Apply additional options
        pond.setOptions(@js($pondLocalizations));
        pond.setOptions(@js($pondProperties));

        console.log('FilePond initialized successfully for {{ $componentId }}');
    }

    // Start initialization
    setTimeout(initFilePond, 100);
});
</script>
