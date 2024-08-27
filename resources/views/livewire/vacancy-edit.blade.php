<form action="/admin/vacancy/{{ $vacancy->id }}" method="POST" enctype="multipart/form-data"
    class="table-container row g-3">
    @csrf
    @method('PUT')

    <div class="card">
        <h5 class="card-header bg-white">Edit Vacancy</h5>
        <div class="card-body">
            <div class="row">
                <div>
                    <div class="d-flex gap-5 mb-3">
                        <div>
                            <input type="radio" value="External" name="type"
                                @if ((old('type') ? old('type') : $vacancy->type) == 'External') checked @endif>External
                        </div>
                        <div>
                            <input type="radio" value="Experience" name="type"
                                @if ((old('type') ? old('type') : $vacancy->type) == 'Experience') checked @endif>Experience
                        </div>
                        <div>
                            <input type="radio" value="Internal" name="type"
                                @if ((old('type') ? old('type') : $vacancy->type) == 'Internal') checked @endif>Internal
                        </div>
                        <div>
                            <input type="radio" value="Assistant Level" name="type"
                                @if ((old('type') ? old('type') : $vacancy->type) == 'Assistant Level') checked @endif>Assistant Level
                        </div>
                    </div>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputEmail4" class="form-label">Position Title</label>
                    <input type="text" name="position_title"
                        value="{{ old('position_title') ? old('position_title') : $vacancy->position_title }}"
                        class="form-control" id="inputEmail4">
                    @error('position_title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="closeDate" class="form-label">Close Datetime</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <select wire:model.live="closure" name="closure"
                                style="border: 0; background-color: transparent;">
                                <option @if ($closure == 'Auto') selected @endif>Auto</option>
                                <option @if ($closure == 'Manual') selected @endif>Manual</option>
                            </select>
                        </span>
                        <input type="datetime-local" step="any" name="close_datetime"
                            value="{{ old('close_datetime') ? old('close_datetime') : $vacancy->close_datetime }}"
                            class="form-control" id="closeDate">
                    </div>
                    @error('close_datetime')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-md-flex col-md-4 gap-3">
                    <div class="">
                        <label for="slots" class="form-label">Slots</label>
                        <input name="number_of_slots"
                            value="{{ old('number_of_slots') ? old('number_of_slots') : $vacancy->number_of_slots }}"
                            type="number" class="form-control" id="slots">
                        @error('number_of_slots')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="benchmark" class="form-label">Benchmark</label>
                        <input name="benchmark" value="{{ old('benchmark') ? old('benchmark') : $vacancy->benchmark }}"
                            type="number" class="form-control" id="benchmark">
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
                    <livewire:multi-input name="employment_type" title="Employment Type & Grade" :inputs="$vacancy->employment_type" />
                </div>
                <div class="col-md-4">
                    <livewire:multi-input name="qualifications" title="Qualification & Criteria" :inputs="$vacancy->qualifications" />
                </div>
                <div class="col-md-4">
                    <livewire:multi-input name="salary_and_benefits" title="Salary & Other Benefits"
                        :inputs="$vacancy->salary_and_benefits" />
                </div>
            </div>

            <hr class="mt-4 mb-4">

            <div @class(['d-flex gap-5']) class="d-flex gap-5">
                @if ($closure == 'Manual')
                    <div>
                        <input type="radio" value="Open" name="status"
                            @if ($vacancy->status == 'Open') checked @endif> Open
                        Vacancy
                    </div>
                    <div>
                        <input type="radio" value="Closed" name="status"
                            @if ($vacancy->status == 'Closed') checked @endif> Close
                        Vacancy
                    </div>
                @endif
            </div>

            @if ($closure == 'Manual')
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @error('delete_attachment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            @endif
        </div>
    </div>
    <div class="d-flex">
        <a href="/admin/vacancy" class="btn me-3"
            style="background-color:gray;border:none;color:white;padding:7px 40px;border-radius:2px;">Cancel</a>
        <button type="submit" class="btn"
            style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</button>
    </div>

</form>
