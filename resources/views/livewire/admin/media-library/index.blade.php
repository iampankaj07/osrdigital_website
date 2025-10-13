<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Media Library</h1>
            <p class="text-gray-600">Upload and manage your media files</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="refreshMedia" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>Refresh
            </button>
            <button wire:click="testConnection" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-wifi mr-2"></i>Test Connection
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if ($uploadSuccess)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            Files uploaded successfully!
        </div>
    @endif

    @if ($errorMessage)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ $errorMessage }}
        </div>
    @endif

    <!-- File Upload Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Upload Files</h2>
            @if(count($uploads) > 0)
                <button wire:click="uploadFiles"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-cloud-upload-alt mr-2"></i>Upload {{ count($uploads) }} File{{ count($uploads) > 1 ? 's' : '' }}
                </button>
            @endif
        </div>

        <div class="w-full" x-data="{ debug: false }" x-init="
            console.log('FilePond container initialized');
            console.log('Livewire available:', typeof Livewire !== 'undefined');
            console.log('$wire available:', typeof $wire !== 'undefined');
            setTimeout(() => {
                console.log('After delay - $wire available:', typeof $wire !== 'undefined');
            }, 1000);
        ">
            <div x-show="typeof $wire === 'undefined'" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                ⚠️ Livewire ($wire) not ready. Please refresh the page if file upload doesn't work.
            </div>
            <div id="filepond-container" wire:ignore>
                <input type="file" id="filepond-input" multiple>
            </div>

            <script>
            document.addEventListener('livewire:initialized', function() {
                console.log('Initializing simple FilePond...');

                function initSimpleFilePond() {
                    if (typeof LivewireFilePond === 'undefined' || typeof @this === 'undefined') {
                        console.log('Waiting for dependencies...');
                        setTimeout(initSimpleFilePond, 200);
                        return;
                    }

                    const input = document.getElementById('filepond-input');
                    if (!input) {
                        console.error('FilePond input not found');
                        return;
                    }

                    console.log('Creating FilePond instance...');
                    const pond = LivewireFilePond.create(input);

                    pond.setOptions({
                        allowMultiple: true,
                        maxFiles: 20,
                        maxFileSize: '10MB',
                        acceptedFileTypes: ['image/*', 'video/*', 'audio/*', 'application/pdf', '.doc', '.docx'],
                        labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span><br><small>Supports: Images, Videos, Audio, PDF, Documents (Max: 10MB each)</small>',
                        server: {
                            process: async (fieldName, file, metadata, load, error, progress) => {
                                console.log('Processing file:', file.name);
                                await @this.upload('uploads', file, (response) => {
                                    console.log('Upload successful:', response);
                                    load(response);
                                }, error, (event) => {
                                    progress(event.detail.progress, event.detail.progress, 100);
                                });
                            }
                        }
                    });

                    console.log('Simple FilePond initialized successfully');
                }

                setTimeout(initSimpleFilePond, 500);
            });
            </script>
        </div>        @if(count($uploads) > 0)
            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ count($uploads) }} file{{ count($uploads) > 1 ? 's' : '' }} ready to upload.
                    Click the "Upload" button to save them to your media library.
                </p>
            </div>
        @endif
    </div>

    <!-- Media Grid -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Media Files ({{ count($mediaItems) }})</h2>
        </div>

        @if(count($mediaItems) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="media-grid">
                @foreach ($mediaItems as $media)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow" data-media-id="{{ $media->id }}">
                        <!-- Media Preview -->
                        <div class="aspect-square bg-gray-200 flex items-center justify-center">
                            @if(str_starts_with($media->mime_type, 'image/'))
                                <img src="{{ $media->getFullUrl() }}" alt="{{ $media->name }}" class="w-full h-full object-cover" />
                            @elseif(str_starts_with($media->mime_type, 'video/'))
                                <div class="flex flex-col items-center text-gray-500">
                                    <i class="fas fa-video text-3xl mb-2"></i>
                                    <span class="text-xs">Video</span>
                                </div>
                            @elseif(str_starts_with($media->mime_type, 'audio/'))
                                <div class="flex flex-col items-center text-gray-500">
                                    <i class="fas fa-music text-3xl mb-2"></i>
                                    <span class="text-xs">Audio</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center text-gray-500">
                                    <i class="fas fa-file text-3xl mb-2"></i>
                                    <span class="text-xs">{{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Media Info -->
                        <div class="p-3">
                            <div class="text-sm font-medium text-gray-900 truncate" title="{{ $media->name }}">
                                {{ $media->name }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $media->human_readable_size }} • {{ $media->created_at->diffForHumans() }}
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <a href="{{ $media->getFullUrl() }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 text-xs">
                                    <i class="fas fa-external-link-alt mr-1"></i>View
                                </a>
                                <button wire:click="deleteMedia({{ $media->id }})"
                                        onclick="confirm('Are you sure you want to delete this file?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-800 text-xs">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="flex flex-col items-center space-y-3">
                    <i class="fas fa-images text-4xl text-gray-300"></i>
                    <p class="text-lg text-gray-500">No media files found</p>
                    <p class="text-sm text-gray-400">Upload some files using the uploader above.</p>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', function() {
    // Listen for Livewire events
    window.addEventListener('mediaDeleted', () => {
        setTimeout(() => {
            @this.call('$refresh');
        }, 100);
    });

    // Listen for reset success message event
    window.addEventListener('resetSuccessMessage', () => {
        setTimeout(() => {
            @this.set('uploadSuccess', false);
        }, 3000); // Reset after 3 seconds
    });

    console.log('Media Library - Livewire initialized successfully');
});

// Fallback for DOMContentLoaded if livewire:initialized doesn't fire
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        if (typeof @this !== 'undefined') {
            console.log('Media Library - Fallback initialization successful');
        }
    }, 100);
});
</script>
@endpush
