<form wire:submit.prevent="apply" class="table-container row g-3">
    @csrf

    <div class="d-flex flex-column-reverse flex-md-row justify-content-between" style="gap: 20px;">
        @if (!$application)
            <h4>Apply for {{ $vacancy->position_title }}</h4>
            {{-- <a href="/vacancy" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a> --}}
        @else
            <h4>Application ID: {{ $application->id }}</h4>
        @endif
    </div>
    <div class="card">
        <h5 class="card-header bg-white">Personal Details</h5>
        <div class="card-body d-flex flex-column flex-md-row gap-3">
            <div class="form-floating flex-grow-1">
                <input wire:model="name" type="text" class="form-control" id="floatingName" placeholder="Tashi"
                    @if ($application) disabled @endif>
                <label for="floatingName">Name</label>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating flex-grow-1">
                <input wire:model="cid" type="number" class="form-control" id="floatingCID" placeholder="------------"
                    @if ($application) disabled @endif>
                <label for="floatingCID">CID</label>
                @error('cid')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating flex-grow-1">
                <input wire:model="email" type="email" autocomplete="off" class="form-control" id="floatingEmail"
                    placeholder="example@email.com" @if ($application) disabled @endif>
                <label for="floatingEmail">Email</label>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header bg-white">Class X Details</h5>
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                <div class="form-floating flex-grow-1">
                    <input wire:model="class_x_school_name" type="text" class="form-control"
                        id="floatingClassXSchoolName" placeholder="" @if ($application) disabled @endif>
                    <label for="floatingClassXSchoolName">School Name</label>
                    @error('class_x_school_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="class_x_completion_year" type="number" class="form-control"
                        id="floatingClassXCompletionYear" placeholder=""
                        @if ($application) disabled @endif>
                    <label for="floatingClassXCompletionYear">Completion Year</label>
                    @error('class_x_completion_year')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <label for="formFileLg" class="form-label">Class X Marksheet</label>
                @if ($application)
                    <div>
                        @if ($application->class_x_marksheet)
                            <a href="{{ $application->class_x_marksheet->src }}" style="color:#00ab41">Download</a>
                        @else
                            No Attachment
                        @endif
                    </div>
                @else
                    <input wire:model="class_x_marksheet" class="form-control" id="formFileLg" type="file">
                @endif
                @error('class_x_marksheet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Marks</h5>
            <ul>
                <li>Pecentage is calculated based on English + 4 best subjects.</li>
                <li>Leave the field for a subject empty if you have not taken the subject.</li>
            </ul>
            <livewire:mark-input name="classX" :subjects="['ENG', 'DZO', 'MATH', 'PHY', 'CHE', 'BIO', 'ECO', 'HIS', 'GEO', 'IT', 'EVS', 'AGFS']" :marks="$application ? $application->class_x_marks : []" :average="$application?->class_x_avg" :disabled="$application ? true : false"/>

            @error('class_x_avg')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card">
        <h5 class="card-header bg-white">Class XII Details</h5>
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                <div class="form-floating flex-grow-1">
                    <input wire:model="class_xii_school_name" type="text" class="form-control" placeholder=""
                        @if ($application) disabled @endif>
                    <label>School Name</label>
                    @error('class_xii_school_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="class_xii_completion_year" type="number" class="form-control" placeholder=""
                        @if ($application) disabled @endif>
                    <label>Completion Year</label>
                    @error('class_xii_completion_year')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <label class="form-label">Class XII Marksheet</label>
                @if ($application)
                    <div>
                        @if ($application->class_xii_marksheet)
                            <a href="{{ $application->class_xii_marksheet->src }}" style="color:#00ab41">Download</a>
                        @else
                            No Attachment
                        @endif
                    </div>
                @else
                    <input wire:model="class_xii_marksheet" class="form-control" type="file">
                @endif
                @error('class_xii_marksheet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Marks</h5>
            <ul>
                <li>Pecentage is calculated based on English + 3 best subjects.</li>
                <li>Leave the field for a subject empty if you have not taken the subject.</li>
            </ul>

            <livewire:stream-input :marks="$application ? $application->class_xii_marks : []" :average="$application?->class_xii_avg" :disabled="$application ? true : false" :stream="$class_xii_stream"/>
            @error('class_xii_avg')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header bg-white">
            Final Score %
        </div>
        <div class="card-body">
            <span class="fs-1 fw-bold">
                {{ $final_score ?? '--.--' }}
            </span>
            <input class="d-none" name="final_score" wire:model="finalScore" readonly>
            @error('final_score')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    @if (!$application)
        <button type="submit" class="btn"
            style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Submit</button>
    @endif
</form>
