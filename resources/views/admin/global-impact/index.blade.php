@extends('admin.layout')

@section('title', 'Global Impact Settings')


@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Global Impact Settings</h1>
            <p class="text-gray-600 mt-2">Manage the "Our Global Impact" section content and statistics</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.global-impact.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Section Header -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Section Header</h3>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" value="{{ old('title', $data['title']) }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtitle <span class="text-red-500">*</span>
                        </label>
                        <textarea name="subtitle" id="subtitle" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('subtitle') border-red-500 @enderror" required>{{ old('subtitle', $data['subtitle']) }}</textarea>
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
                <p class="text-sm text-gray-600 mb-6">Add up to 6 statistics to display in the Global Impact section. Each stat needs a number and label.</p>
                
                <div id="stats-container">
                    @foreach($data['stats'] as $index => $stat)
                        <div class="stat-item border border-gray-200 rounded-lg p-4 mb-4" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-medium text-gray-700">Statistic {{ $index + 1 }}</h4>
                                @if($index > 0)
                                    <button type="button" class="text-red-600 hover:text-red-800 text-sm remove-stat">
                                        <i class="fas fa-trash mr-1"></i>
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number</label>
                                    <input type="text" name="stats[{{ $index }}][number]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="{{ old("stats.{$index}.number", $stat['number']) }}" placeholder="500+" required>
                                </div>
                                
                                <!-- Label -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                                    <input type="text" name="stats[{{ $index }}][label]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="{{ old("stats.{$index}.label", $stat['label']) }}" placeholder="Movies Published" required>
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <button type="button" id="add-stat" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add Another Statistic
                </button>
                
                @error('stats')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Global Impact
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statsContainer = document.getElementById('stats-container');
    const addStatBtn = document.getElementById('add-stat');
    let statIndex = {{ count($data['stats']) }};

    // Add new statistic
    addStatBtn.addEventListener('click', function() {
        if (statsContainer.children.length >= 6) {
            alert('Maximum 6 statistics allowed');
            return;
        }

        const statItem = document.createElement('div');
        statItem.className = 'stat-item border border-gray-200 rounded-lg p-4 mb-4';
        statItem.setAttribute('data-index', statIndex);
        
        statItem.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-700">Statistic ${statIndex + 1}</h4>
                <button type="button" class="text-red-600 hover:text-red-800 text-sm remove-stat">
                    <i class="fas fa-trash mr-1"></i>
                    Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Number</label>
                    <input type="text" name="stats[${statIndex}][number]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="500+" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                    <input type="text" name="stats[${statIndex}][label]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Movies Published" required>
                </div>
                
            </div>
        `;

        statsContainer.appendChild(statItem);
        statIndex++;

        // Initialize Select2 for the new icon select
        $(statItem).find('.icon-select').select2({
            placeholder: 'Select an icon...',
            allowClear: true,
            width: '100%',
            templateResult: formatIconOption,
            templateSelection: formatIconSelection,
            escapeMarkup: function(markup) {
                return markup;
            }
        });

        // Update remove buttons
        updateRemoveButtons();
    });

    // Remove statistic
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-stat');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (statsContainer.children.length <= 1) {
                    alert('At least one statistic is required');
                    return;
                }
                
                this.closest('.stat-item').remove();
                
                // Renumber remaining items
                const remainingItems = statsContainer.querySelectorAll('.stat-item');
                remainingItems.forEach((item, index) => {
                    item.setAttribute('data-index', index);
                    item.querySelector('h4').textContent = `Statistic ${index + 1}`;
                    
                    // Update input names
                    const inputs = item.querySelectorAll('input');
                    inputs[0].name = `stats[${index}][number]`;
                    inputs[1].name = `stats[${index}][label]`;
                    inputs[2].name = `stats[${index}][icon]`;
                });
                
                statIndex = remainingItems.length;
            });
        });
    }

    // Initialize remove buttons
    updateRemoveButtons();
    
});
</script>

@endsection
