<div>
    <div>
        <label class="fw-bold">Stream</label>
        <div class="d-flex gap-5 mb-3">
            <div>
                <input type="radio" value="science" wire:model.live="stream" wire:change="change" @if($disabled_stream) disabled @endif> Science
            </div>
            <div>
                <input type="radio" value="commerce" wire:model.live="stream" wire:change="change" @if($disabled_stream) disabled @endif> Commerce
            </div>
            <div>
                <input type="radio" value="arts" wire:model.live="stream" wire:change="change" @if($disabled_stream) disabled @endif> Arts
            </div>
        </div>
        @error('stream')
                <div style="color:red;">{{ $message }}</div>
            @enderror
    </div>

    @if ($stream == 'science')
        <livewire:mark-input name="classXII" :best="3" :subjects="['ENG', 'DZO', 'MATH', 'PHY', 'CHE', 'BIO', 'IT']" :marks="$marks" :average="$average" :disabled="$disabled"/>
    @elseif ($stream == 'commerce')
        <livewire:mark-input name="classXII" :best="3" :subjects="['ENG', 'DZO', 'MATH', 'IT', 'COM', 'ECO', 'ACC']" :marks="$marks" :average="$average" :disabled="$disabled"/>
    @elseif ($stream == 'arts')
        <livewire:mark-input name="classXII" :best="3" :subjects="['ENG', 'DZO', 'MATH', 'IT', 'ECO', 'GEO', 'HIS', 'MEDIA', 'RIGZHUNG']" :marks="$marks" :average="$average" :disabled="$disabled"/>
    @endif
</div>
