@extends('admin.layout')

@section('title', 'Edit Setting')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Setting</h1>
        <a href="{{ route('admin.settings') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Settings
        </a>
    </div>

    <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">Key</label>
                    <input type="text" name="key" id="key" value="{{ old('key', $setting->key) }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                    <p class="mt-1 text-sm text-gray-500">Key cannot be changed after creation</p>
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="string" {{ $setting->type === 'string' ? 'selected' : '' }}>String</option>
                        <option value="text" {{ $setting->type === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="number" {{ $setting->type === 'number' ? 'selected' : '' }}>Number</option>
                        <option value="boolean" {{ $setting->type === 'boolean' ? 'selected' : '' }}>Boolean</option>
                        <option value="json" {{ $setting->type === 'json' ? 'selected' : '' }}>JSON</option>
                        <option value="image" {{ $setting->type === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="file" {{ $setting->type === 'file' ? 'selected' : '' }}>File</option>
                    </select>
                </div>
                
                <div>
                    <label for="group" class="block text-sm font-medium text-gray-700 mb-2">Group</label>
                    <input type="text" name="group" id="group" value="{{ old('group', $setting->group) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_public" id="is_public" {{ $setting->is_public ? 'checked' : '' }} class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="is_public" class="ml-2 block text-sm text-gray-900">Is Public</label>
                </div>
            </div>
            
            <div class="mt-6">
                <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                @if($setting->type === 'text')
                    <textarea name="value" id="value" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('value', is_array($setting->value) ? json_encode($setting->value, JSON_PRETTY_PRINT) : $setting->value) }}</textarea>
                @elseif($setting->type === 'boolean')
                    <select name="value" id="value" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="1" {{ $setting->value ? 'selected' : '' }}>True</option>
                        <option value="0" {{ !$setting->value ? 'selected' : '' }}>False</option>
                    </select>
                @elseif($setting->type === 'json')
                    <textarea name="value" id="value" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm">{{ old('value', is_array($setting->value) ? json_encode($setting->value, JSON_PRETTY_PRINT) : $setting->value) }}</textarea>
                @else
                    <input type="text" name="value" id="value" value="{{ old('value', is_array($setting->value) ? json_encode($setting->value) : $setting->value) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @endif
            </div>
            
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $setting->description) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.settings') }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Update Setting
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const valueField = document.getElementById('value');
    const currentValue = valueField.value;
    
    if (this.value === 'boolean') {
        valueField.outerHTML = `
            <select name="value" id="value" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        `;
    } else if (this.value === 'text' || this.value === 'json') {
        valueField.outerHTML = `
            <textarea name="value" id="value" rows="${this.value === 'json' ? '6' : '4'}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent ${this.value === 'json' ? 'font-mono text-sm' : ''}">${currentValue}</textarea>
        `;
    } else {
        valueField.outerHTML = `
            <input type="text" name="value" id="value" value="${currentValue}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        `;
    }
});
</script>
@endsection
