<form wire:submit.prevent="apply" class="table-container row g-3">
    @csrf

    <div class="d-flex flex-column-reverse flex-md-row justify-content-between" style="gap: 20px;">
        @if (!$application)
            <h4>Apply for {{ $vacancy->position_title }}</h4>
            {{-- <a href="/vacancy" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a> --}}
        @else
            <div class="d-flex justify-content-between align-items-center w-100">
                <h4>Application ID: {{ $application->id }}</h4>
                @if (!$is_editing)
                    <button type="button" wire:click="onEditButtonPressed" class="btn btn-link p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="none" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </button>
                @else
                    <div>
                        <button type="button" class="btn" wire:click="onEditCancelButtonPressed"
                            style="background-color:gray;border:none;color:white;padding:7px 20px;border-radius:2px;">Cancel
                            Edit</button>
                        <button type="button" class="btn" wire:click="edit"
                            style="background-color:#00ab41;border:none;color:white;padding:7px 20px;border-radius:2px;">Save</button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @if (!$application && $last_page > 1)
        <div class="d-flex justify-content-between align-items-center">
            @for ($i = 1; $i <= $last_page; $i++)
                <div @class([
                    'd-flex justify-content-center align-items-center rounded-circle fs-5',
                    'text-white fw-bold' => $i == $current_page,
                ]) @style(['width: 40px; height: 40px; border: 1px solid green; color: #00ab41;', 'background-color:#00ab41;' => $i == $current_page])>
                    {{ $i }}
                </div>
                @if ($i != $last_page)
                    <div class="flex-grow-1" style="height: 1px; background-color: #00ab41; margin: 0px 0px;"></div>
                @endif
            @endfor
        </div>
    @endif

    <div @class([
        'd-none' => !($application || (!$application && $current_page == 1)),
    ])>
        <div class="card">
            <h5 class="card-header bg-white">Personal Details</h5>
            <div class="card-body d-flex flex-column flex-md-row gap-3">
                <div class="form-floating flex-grow-1">
                    <input wire:model="name" type="text" class="form-control" id="floatingName"
                        placeholder="------------" @if ($application && !$is_editing) disabled @endif>
                    <label for="floatingName">Name</label>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="cid" type="number" class="form-control" id="floatingCID"
                        placeholder="------------" @if ($application && !$is_editing) disabled @endif>
                    <label for="floatingCID">CID</label>
                    @error('cid')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="email" type="email" autocomplete="off" class="form-control" id="floatingEmail"
                        placeholder="example@email.com" @if ($application && !$is_editing) disabled @endif>
                    <label for="floatingEmail">Email</label>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-body row">
                {{-- <livewire:photo-input name="" title="Passport Size Photo" ratio="9:7" />
                     --}}
                @if ($vacancy->type != 'Internal')
                    <div class="col-md-4 d-flex justify-content-center">
                        <div style="width: 250px;">
                            <label for="photo" class="form-label">Passport size photo<x-required /> <x-gray>( Ratio
                                    9:7
                                    )</x-gray></label>
                            @if (!$application)
                                <input wire:model="passport_photo" class="form-control mb-3" id="photo"
                                    type="file">
                                @if ($passport_photo)
                                    @if (!$errors->has('passport_photo'))
                                        <img src="{{ $passport_photo->temporaryUrl() }}" alt="Selected Image"
                                            style="width: 250px; height: 300px; object-fit: cover;">
                                    @endif
                                @else
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="height: 300px; border: 2px dashed #aaaaaa;">
                                        <x-gray>Passport size photo</x-gray>
                                    </div>
                                @endif
                            @else
                                <img src="{{ $application->applicationFiles->where('type', 'passport_photo')->first() }}"
                                    alt="Passport Photo" style="width: 250px; height: 300px; object-fit: cover;">
                            @endif
                            @error('passport_photo')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="col-md-8 mt-5 mt-md-0">
                    @if ($vacancy->type != 'Internal')
                        <div class="mb-5">
                            <label class="form-label">Valid Citizenship Identity Card<x-required /></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'citizenship_identity_card')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'citizenship_identity_card')->first()->src }}"
                                            style="color:#00ab41">Download</a>
                                    @else
                                        No Attachment
                                    @endif
                                </div>
                            @else
                                <input wire:model="citizenship_identity_card" class="form-control mb-3" id="photo"
                                    type="file">
                            @endif

                            @error('citizenship_identity_card')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Security Clearance Certificate<x-required /></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'security_clearance_certificate')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'security_clearance_certificate')->first()->src }}"
                                            style="color:#00ab41">Download</a>
                                    @else
                                        No Attachment
                                    @endif
                                </div>
                            @else
                                <input wire:model="security_clearance_certificate" class="form-control mb-3"
                                    id="photo" type="file">
                            @endif
                            @error('security_clearance_certificate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Medical Certificate<x-required /> <x-gray>( Not exceeding 6 months
                                    from the date of issue )</x-gray></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'medical_certificate')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'medical_certificate')->first()->src }}"
                                            style="color:#00ab41">Download</a>
                                    @else
                                        No Attachment
                                    @endif
                                </div>
                            @else
                                <input wire:model="medical_certificate" class="form-control mb-3" id="photo"
                                    type="file">
                            @endif
                            @error('medical_certificate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div @class(['mb-5', 'w-50' => $vacancy->type == 'Internal'])>
                        <label class="form-label">CV<x-required /></label>
                        @if ($application)
                            <div>
                                @if ($application->applicationFiles->where('type', 'cv')->first())
                                    <a href="{{ $application->applicationFiles->where('type', 'cv')->first()->src }}"
                                        style="color:#00ab41">Download</a>
                                @else
                                    No Attachment
                                @endif
                            </div>
                        @else
                            <input wire:model="cv" class="form-control mb-3" id="photo" type="file">
                        @endif
                        @error('cv')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($vacancy->type == 'Experience')
                        <div>
                            <label class="form-label">NOC <x-gray>( From current employer, if already employed
                                    )</x-gray></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'noc')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'noc')->first()->src }}"
                                            style="color:#00ab41">Download</a>
                                    @else
                                        No Attachment
                                    @endif
                                </div>
                            @else
                                <input wire:model="noc" class="form-control mb-3" id="photo" type="file">
                            @endif
                            @error('noc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div @class([
        'd-none' => !(
            ($application && $vacancy->type == 'External') ||
            (!$application && $vacancy->type == 'External' && $current_page == 2)
        ),
    ])>
        <div class="card">
            <h5 class="card-header bg-white">Class X Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_x_school_name" type="text" class="form-control"
                            id="floatingClassXSchoolName" placeholder=""
                            @if ($application && !$is_editing) disabled @endif>
                        <label for="floatingClassXSchoolName">School Name</label>
                        @error('class_x_school_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_x_completion_year" type="number" class="form-control"
                            id="floatingClassXCompletionYear" placeholder=""
                            @if ($application && !$is_editing) disabled @endif>
                        <label for="floatingClassXCompletionYear">Completion Year</label>
                        @error('class_x_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="formFileLg" class="form-label">Class X Marksheet <span style="opacity: 0.5;">(PDF
                            Max:1mb)</span></label>
                    @if ($application)
                        <div>
                            @if ($application->applicationFiles->where('type', 'class_x_marksheet')->first())
                                <a href="{{ $application->applicationFiles->where('type', 'class_x_marksheet')->first()->src }}"
                                    style="color:#00ab41">Download</a>
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

                @if ($is_editing)
                    <livewire:mark-input name="classX" :subjects="['ENG', 'DZO', 'MATH', 'PHY/CHE/BIO', 'HIS/GEO', 'ECO', 'IT', 'EVS', 'AGFS']" :marks="$application ? $application->class_x_marks : $class_x_marks" :average="$application ? $application->class_x_avg : $class_x_avg" />
                @else
                    <livewire:mark-input name="classX" :subjects="['ENG', 'DZO', 'MATH', 'PHY/CHE/BIO', 'HIS/GEO', 'ECO', 'IT', 'EVS', 'AGFS']" :marks="$application ? $application->class_x_marks : $class_x_marks" :average="$application ? $application->class_x_avg : $class_x_avg"
                        :disabled="$application ? true : false" />
                @endif

                @error('class_x_marks')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
                @error('class_x_avg')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div @class([
        'd-none' => !(
            ($application && $vacancy->type == 'External') ||
            (!$application && $vacancy->type == 'External' && $current_page == 3)
        ),
    ])>
        <div class="card">
            <h5 class="card-header bg-white">Class XII Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_xii_school_name" type="text" class="form-control" placeholder=""
                            @if ($application && !$is_editing) disabled @endif>
                        <label>School Name</label>
                        @error('class_xii_school_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_xii_completion_year" type="number" class="form-control"
                            placeholder="" @if ($application && !$is_editing) disabled @endif>
                        <label>Completion Year</label>
                        @error('class_xii_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="form-label">Class XII Marksheet <span style="opacity: 0.5;">(PDF
                            Max:1mb)</span></label>
                    @if ($application)
                        <div>
                            @if ($application->applicationFiles->where('type', 'class_xii_marksheet')->first())
                                <a href="{{ $application->applicationFiles->where('type', 'class_xii_marksheet')->first()->src }}"
                                    style="color:#00ab41">Download</a>
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

                @if ($is_editing)
                    <livewire:stream-input :marks="$application ? $application->class_xii_marks : $class_xii_marks" :average="$application ? $application->class_xii_avg : $class_xii_avg" :stream="$class_xii_stream" />
                @else
                    <livewire:stream-input :marks="$application ? $application->class_xii_marks : $class_xii_marks" :average="$application ? $application->class_xii_avg : $class_xii_avg" :disabled="$application ? true : false"
                        :stream="$class_xii_stream" />
                @endif

                @error('class_xii_marks')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
                @error('class_xii_avg')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div @class([
        'd-none' => !(
            ($application && $vacancy->type != 'Internal') ||
            (!$application && $vacancy->type == 'External' && $current_page == 4) ||
            (!$application && $vacancy->type == 'Experience' && $current_page == 2)
        ),
    ])>
        <div class="card" style="margin-bottom: 20px;">
            <h5 class="card-header bg-white">Degree/Diploma/VTI Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="university_or_college_name" type="text" class="form-control"
                            placeholder="" @if ($application && !$is_editing) disabled @endif>
                        <label>University/College Name</label>
                        @error('university_or_college_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="university_or_college_course_name" type="text" class="form-control"
                            placeholder="" @if ($application && !$is_editing) disabled @endif>
                        <label>Course Name</label>
                        @error('university_or_college_course_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="university_or_college_completion_year" type="number" class="form-control"
                            placeholder="" @if ($application && !$is_editing) disabled @endif>
                        <label>Completion Year</label>
                        @error('university_or_college_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="flex-grow-1">
                        <label class="form-label">Percentage</label>
                        <input wire:model="university_or_college_percentage" wire:change="onPercentageChanged"
                            type="number" class="form-control" step="0.01"
                            @if ($application && !$is_editing) disabled @endif>
                        @error('university_or_college_percentage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label">Degree/Diploma/VTI Marksheet<span style="opacity: 0.5;"> (PDF
                                Max:1mb)</span></label>
                        @if ($application)
                            <div>
                                @if ($application->applicationFiles->where('type', 'university_or_college_marksheet')->first())
                                    <a href="{{ $application->applicationFiles->where('type', 'university_or_college_marksheet')->first()->src }}"
                                        style="color:#00ab41">Download</a>
                                @else
                                    No Attachment
                                @endif
                            </div>
                        @else
                            <input wire:model="university_or_college_marksheet" class="form-control" type="file">
                        @endif
                        @error('university_or_college_marksheet')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>

        @if ($vacancy->type == 'External')
            <div class="card text-center">
                <div class="card-header bg-white">
                    Final Score <span style="opacity: 0.5; user-select: none;">(30:30:40)</span>
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
        @endif
    </div>

    <div @class([
        'd-none' => !(
            ($application && $vacancy->type == 'Experience') ||
            (!$application && $vacancy->type == 'Experience' && $current_page == 3)
        ),
    ])>
        <div class="card" style="margin-bottom: 20px;">
            <h5 class="card-header bg-white">Masters Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="masters_institution_name" type="text" class="form-control"
                            placeholder="" @if ($application) disabled @endif>
                        <label>Masters Institution Name</label>
                        @error('masters_institution_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="masters_course_name" type="text" class="form-control" placeholder=""
                            @if ($application) disabled @endif>
                        <label>Course Name</label>
                        @error('masters_course_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="masters_completion_year" type="number" class="form-control"
                            placeholder="" @if ($application) disabled @endif>
                        <label>Completion Year</label>
                        @error('masters_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="flex-grow-1">
                        <label class="form-label">Percentage</label>
                        <input wire:model="masters_percentage" wire:change="onPercentageChanged" type="number"
                            class="form-control" step="0.01" @if ($application) disabled @endif>
                        @error('masters_percentage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label">Masters Marksheet<span style="opacity: 0.5;"> (PDF
                                Max:1mb)</span></label>
                        @if ($application)
                            <div>
                                @if ($application->applicationFiles->where('type', 'masters_marksheet')->first())
                                    <a href="{{ $application->applicationFiles->where('type', 'masters_marksheet')->first() }}"
                                        style="color:#00ab41">Download</a>
                                @else
                                    No Attachment
                                @endif
                            </div>
                        @else
                            <input wire:model="masters_marksheet" class="form-control" type="file">
                        @endif
                        @error('masters_marksheet')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>

        @if ($vacancy->type == 'Experience')
            <div class="card text-center">
                <div class="card-header bg-white">
                    Final Score <span style="opacity: 0.5; user-select: none;">(30:30:40)</span>
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
        @endif
    </div>

    @if (!$application)
        <div class="d-flex justify-content-center justify-content-md-between">
            @if ($current_page == 1)
                <div></div>
            @else
                <button type="button" class="btn" wire:click="back"
                    style="background-color:gray;border:none;color:white;padding:7px 40px;border-radius:2px;">Back</button>
            @endif
            @if ($current_page == $last_page)
                <div wire:loading class="spinner-border text-success" role="status">
                </div>
                <button type="submit" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Submit</button>
            @else
                <button type="button" class="btn" wire:click="next"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Next</button>
            @endif
        </div>
    @endif
</form>
