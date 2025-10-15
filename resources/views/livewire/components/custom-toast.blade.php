<div class="custom-toast-container" wire:ignore.self>
    @foreach($toasts as $toast)
        <div
            class="custom-toast custom-toast-{{ $toast['type'] }} animate-slide-in"
            id="toast-{{ $toast['id'] }}"
            x-data="{ show: true, autoRemove: true }"
            x-show="show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-init="
                if (autoRemove) {
                    setTimeout(() => {
                        show = false;
                        setTimeout(() => {
                            $wire.removeToast('{{ $toast['id'] }}');
                        }, 200);
                    }, {{ $toast['duration'] }});
                }
            "
        >
            <div class="custom-toast-content">
                <div class="custom-toast-icon">
                    @switch($toast['type'])
                        @case('success')
                            <i class="fas fa-check-circle"></i>
                            @break
                        @case('warning')
                            <i class="fas fa-exclamation-triangle"></i>
                            @break
                        @case('error')
                            <i class="fas fa-times-circle"></i>
                            @break
                        @case('delete')
                            <i class="fas fa-trash-alt"></i>
                            @break
                        @default
                            <i class="fas fa-info-circle"></i>
                    @endswitch
                </div>

                <div class="custom-toast-body">
                    @if($toast['title'])
                        <div class="custom-toast-title">{{ $toast['title'] }}</div>
                    @endif
                    @if($toast['message'])
                        <div class="custom-toast-message">{{ $toast['message'] }}</div>
                    @endif
                </div>

                <button
                    type="button"
                    class="custom-toast-close"
                    @click="
                        show = false;
                        setTimeout(() => {
                            $wire.removeToast('{{ $toast['id'] }}');
                        }, 200);
                    "
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Progress bar -->
            <div class="custom-toast-progress">
                <div
                    class="custom-toast-progress-bar"
                    x-data="{ progress: 0 }"
                    x-init="
                        let duration = {{ $toast['duration'] }};
                        let interval = 50;
                        let increment = (100 / (duration / interval));

                        let timer = setInterval(() => {
                            progress += increment;
                            if (progress >= 100) {
                                clearInterval(timer);
                            }
                        }, interval);
                    "
                    :style="`width: ${progress}%`"
                ></div>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('livewire:initialized', function () {
        // Listen for auto-remove events
        Livewire.on('auto-remove-toast', (event) => {
            setTimeout(() => {
                Livewire.dispatch('removeToast', { toastId: event.id });
            }, event.duration);
        });
    });
</script>
