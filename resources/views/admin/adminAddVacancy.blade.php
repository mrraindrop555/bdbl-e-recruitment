<x-layouts.admin>
    <form id="form" action="/admin/vacancy" method="POST" enctype="multipart/form-data"
        class="table-container row g-3">
        @csrf

        <div class="card">
            <h5 class="card-header bg-white">Add Vacancy</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Position Title</label>
                        <input type="text" name="position_title" value="{{ old('position_title') }}"
                            class="form-control" id="inputEmail4">
                        @error('position_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-md-flex col-md-4 gap-3">
                        <div class="">
                            <label for="closeDate" class="form-label">Close Date</label>
                            <input type="date" name="close_date" value="{{ old('benchmark') }}" min="1"
                                class="form-control" id="closeDate">
                            @error('close_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="slots" class="form-label">Slots</label>
                            <input name="number_of_slots" value="{{ old('number_of_slots') }}" type="number"
                                class="form-control" id="slots">
                            @error('number_of_slots')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="benchmark" class="form-label">Benchmark</label>
                            <input name="benchmark" value="{{ old('benchmark') }}" type="number" class="form-control"
                                id="benchmark">
                            @error('benchmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="formFile" class="form-label">TOR Attachment</label>
                        <input class="form-control" type="file" name="attachment" value="{{ old('attachment') }}"
                            id="formFile">
                        @error('attachment')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <livewire:multi-input name="employment_type" title="Employment Type & Grade" />
                    </div>
                    <div class="col-md-4">
                        <livewire:multi-input name="qualifications" title="Qualification & Criteria" />
                    </div>
                    <div class="col-md-4">
                        <livewire:multi-input name="salary_and_benefits" title="Salary & Other Benefits" />
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <a href="/admin/vacancy" class="btn me-3"
                style="background-color:gray;border:none;color:white;padding:7px 40px;border-radius:2px;">Cancel</a>
            <button type="submit" class="btn" id="save"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</button>
        </div>

    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#form').submit(function(event) {
                    $("#save").prop('disabled', true);
                    return true;
                });
            });
        </script>
    @endpush
</x-layouts.admin>
