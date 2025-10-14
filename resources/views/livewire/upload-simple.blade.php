<div style="max-height: 100px;">
    <x-filepond::upload
        wire:model="uploads"
        :multiple="$multiple"
        accepted-file-types="image/*"
        max-file-size="10MB"
        placeholder="Drop image here or <span class='filepond--label-action'>Browse</span>"
    />
</div>
