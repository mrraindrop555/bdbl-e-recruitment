<div>
    @if (!$delete)
        <button type="button" class="btn btn-secondary" wire:click="deleteFile">Delete</button>
    @else
        <input class="form-control" type="file" name="{{ $name }}" value="{{ old($name) }}">
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    @endif
    <input class="d-none" name="delete_{{ $name }}" wire:model="delete" readonly>
</div>
