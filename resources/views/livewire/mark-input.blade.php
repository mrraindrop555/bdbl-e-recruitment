<div>
    <div class="d-flex flex-column flex-md-row gap-3 mb-3">
        @foreach ($subjects as $subject)
            <div class="form-floating flex-grow-1">
                <input name="{{ $name }}[{{ $subject }}][mark]" wire:model="marks.{{ $subject }}.mark"
                    wire:change="change" type="number" step="0.01" class="form-control"
                    style="{{ $marks[$subject]['highlight'] ? 'background-color: #d4ffd4;' : '' }}" @if($disabled) disabled @endif>
                <input class="d-none" name="{{ $name }}[{{ $subject }}][highlight]"
                    wire:model="marks.{{ $subject }}.highlight" readonly>
                <label>{{ $subject }}</label>
            </div>
        @endforeach
    </div>
    <div class="form-floating flex-grow-1">
        <input type="text" class="form-control" value="{{ $average ?? '--.--' }}" disabled>
        <label>Average</label>
    </div>
</div>
