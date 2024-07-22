<div>
    <label for="inputAddress" class="form-label">{{ $title }}</label>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <div>
        @foreach ($inputs as $index => $input)
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="{{ "{$name}[]" }}"
                    wire:model="inputs.{{ $index }}">
                <div class="input-group-append">
                    <button wire:click="remove({{ $index }})" class="btn btn-outline-secondary remove-btn px-3"
                        type="button">-</button>
                </div>
            </div>
            @error("{$name}.{$loop->index}")
                <div class="text-danger">{{ $message }}</div>
            @enderror
        @endforeach
    </div>
    <button wire:click="add" type="button" class="btn btn-outline-secondary">Add +</button>
</div>
