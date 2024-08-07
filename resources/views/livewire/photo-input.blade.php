<div style="width: 250px;">
    <label for="formFileLg" class="form-label">{{ $title }} <span style="opacity: 0.5; user-select: none;">( Ratio
            {{ $ratio }} )</span></label>
    <input wire:model="photo" class="form-control mb-3" id="formFileLg" type="file" wire:change="change">
    @if ($photo)
        @if ($errors->has('photo'))
            <span class="error text-danger">{{ $errors->first('photo') }}</span>
        @else
            <img src="{{ $photo->temporaryUrl() }}" alt="Selected Image"
                style="width: 250px; height: 300px; object-fit: cover;">
        @endif
    @else
        <div class="d-flex justify-content-center align-items-center"
            style="height: 300px; border: 2px dashed #aaaaaa;">
            <span style="opacity: 0.3; user-select: none;">{{ $title }}</span>
        </div>
    @endif
</div>
