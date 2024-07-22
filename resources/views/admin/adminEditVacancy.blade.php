<x-layouts.admin>
    <form action="/admin/vacancy/{{ $vacancy->id }}" method="POST" enctype="multipart/form-data"
        class="table-container row g-3">
        @csrf
        @method('PUT')

        <div class="card">
            <h5 class="card-header bg-white">Edit Vacancy</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Position Title</label>
                        <input type="text" name="position_title"
                            value="{{ old('position_title') ?? $vacancy->position_title }}" class="form-control"
                            id="inputEmail4">
                        @error('position_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-md-flex col-md-4 gap-3">
                        <div class="">
                            <label for="closeDate" class="form-label">Close Date</label>
                            <input type="date" name="close_date"
                                value="{{ old('close_date') ?? $vacancy->close_date }}" class="form-control"
                                id="closeDate">
                            @error('close_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="slots" class="form-label">Slots</label>
                            <input name="number_of_slots"
                                value="{{ old('number_of_slots') ?? $vacancy->number_of_slots }}" type="number"
                                class="form-control" id="slots">
                            @error('number_of_slots')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <label for="benchmark" class="form-label">Benchmark</label>
                            <input name="benchmark" value="{{ old('benchmark') ?? $vacancy->benchmark }}" type="number"
                                class="form-control" id="benchmark">
                            @error('benchmark')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="formFile" class="form-label">TOR Attachment</label>
                        <livewire:file-update-input name="attachment" :file="$vacancy->attachment" />
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <livewire:multi-input name="employment_type" title="Employment Type & Grade"
                            :inputs="$vacancy->employment_type" />
                    </div>
                    <div class="col-md-4">
                        <livewire:multi-input name="qualifications" title="Qualification & Criteria"
                            :inputs="$vacancy->qualifications" />
                    </div>
                    <div class="col-md-4">
                        <livewire:multi-input name="salary_and_benefits" title="Salary & Other Benefits"
                            :inputs="$vacancy->salary_and_benefits" />
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="d-flex gap-5">
                    <div>
                        <input type="radio" value="Open" name="status"
                            @if ($vacancy->status == 'Open') checked @endif> Open Vacancy
                    </div>
                    <div>
                        <input type="radio" value="Closed" name="status"
                            @if ($vacancy->status == 'Closed') checked @endif> Close Vacancy
                    </div>
                </div>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('delete_attachment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-flex">
            <a href="/admin/vacancy" class="btn me-3"
                style="background-color:gray;border:none;color:white;padding:7px 40px;border-radius:2px;">Cancel</a>
            <button type="submit" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</button>
        </div>

    </form>

</x-layouts.admin>
