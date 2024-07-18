@props(['title' => 'Title', 'name'])

<div>
    <label for="inputAddress" class="form-label">{{ $title }}</label>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <div id="input-list-1">
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
                    <button class="btn btn-danger remove-btn" type="button">Remove</button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-primary" id="add-input-1">Add More</button>

    @push('scripts')
        <script>
            $('#add-input-1').click(function() {
                let inputHtml = `
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="employment_type[]">
                            <div class="input-group-append">
                                <button class="btn btn-danger remove-btn" type="button">Remove</button>
                            </div>
                        </div>`;
                $('#input-list-1').append(inputHtml);
            });

            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.input-group').remove();
            });
        </script>
    @endpush
</div>
