@props(['title' => 'Title', 'name', 'id'])

<div>
    <label for="inputAddress" class="form-label">{{ $title }}</label>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <div id="{{ $id }}">
        @if (old($name))
            @foreach (old($name) as $value)
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="{{ "{$name}[]" }}" value="{{ $value }}">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-btn" type="button">Remove</button>
                    </div>
                </div>

                @error("{$name}.{$loop->index}")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            @endforeach
        @else
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="{{ "{$name}[]" }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary remove-btn px-3" type="button">-</button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-secondary" id="add-input-{{ $id }}">Add +</button>

    @push('scripts')
        <script>
            $(`#add-input-${@json($id)}`).click(function() {
                let inputHtml = `
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="${@json($name)}[]" }}">
                            <div class="input-group-append">
                                <button class="btn btn-danger remove-btn" type="button">Remove</button>
                            </div>
                        </div>`;
                $(`#${@json($id)}`).append(inputHtml);
            });

            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.input-group').remove();
            });
        </script>
    @endpush
</div>
