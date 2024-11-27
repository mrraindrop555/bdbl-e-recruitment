<form wire:submit.prevent="apply" class="table-container row g-3">
    @csrf

    @if (!$is_resubmission)
        <div class="d-flex flex-column-reverse flex-md-row justify-content-between" style="gap: 20px;">
            @if (!$application)
                <h4>Apply for {{ $vacancy->position_title }}</h4>
                {{-- <a href="/vacancy" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a> --}}
            @else
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h4>Application ID: {{ $application->id }}</h4>
                    @if ($state != 'editing')
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
    @else
        <div>
            <label for="exampleFormControlTextarea1" class="form-label">Rejection Remarks</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $application->rejection_remarks }}</textarea>
        </div>
    @endif

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
                        placeholder="------------" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                    <label for="floatingName">Name<x-required /></label>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="cid" type="number" class="form-control" id="floatingCID"
                        placeholder="------------" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                    <label for="floatingCID">CID<x-required /></label>
                    @error('cid')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating flex-grow-1">
                    <input wire:model="email" type="text" autocomplete="off" class="form-control" id="floatingEmail"
                        placeholder="example@email.com" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                    <label for="floatingEmail">Email<x-required /></label>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @if ($vacancy->type == 'Internal')
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="present_position" type="text" class="form-control" id="floatingPP"
                            placeholder="------------" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label for="floatingPP">Present Position<x-required /></label>
                        @error('present_position')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="present_division" type="text" class="form-control" id="floatingPD"
                            placeholder="------------" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label for="floatingPD">Present Division<x-required /></label>
                        @error('present_division')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="number_of_years_served" type="number" autocomplete="off"
                            class="form-control" id="floatingNY" placeholder="example@email.com"
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label for="floatingNT">Number of years served<x-required /></label>
                        @error('number_of_years_served')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <label for="reason" class="display-block">Reason</label>
                    <textarea wire:model="reason" id="reason" data-gramm="false" class="form-control" rows="3"
                        @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif></textarea>
                    @error('reason')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="card-body row">
                {{-- <livewire:photo-input name="" title="Passport Size Photo" ratio="9:7" />
                     --}}
                @if ($vacancy->type != 'Internal')
                    <div class="col-md-4 d-flex justify-content-center">
                        <div style="width: 250px;">
                            <label for="photo" class="form-label">Passport size photo<x-required /></label>
                            @if (!$application || ($is_resubmission && $passport_photo))
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
                                <img src="{{ $application->applicationFiles->where('type', 'passport_photo')->first()?->src }}"
                                    alt="Passport Photo" style="width: 250px; height: 300px; object-fit: cover;">
                                @if ($is_resubmission)
                                    <input wire:model="passport_photo" class="form-control mb-3" id="photo"
                                        type="file">
                                @endif
                            @endif
                            @error('passport_photo')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="col-md-8 mt-5 mt-md-0">
                    <x-gray>Accepted formats: pdf,jpeg,png,jpg</x-gray>
                    @if ($vacancy->type != 'Internal')
                        <div class="mb-5">
                            <label class="form-label">Valid Citizenship Identity Card<x-required /></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'citizenship_identity_card')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'citizenship_identity_card')->first()->src }}"
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif

                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="citizenship_identity_card" class="form-control mb-3"
                                            id="photo" type="file">
                                    @endif
                                </div>
                            @else
                                <input wire:model="citizenship_identity_card" class="form-control mb-3"
                                    id="photo" type="file">
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
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif

                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="security_clearance_certificate" class="form-control mb-3"
                                            id="photo" type="file">
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
                            <label class="form-label">Medical Certificate<x-required /> <x-gray>( Not exceeding 6
                                    months
                                    from the date of issue )</x-gray></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'medical_certificate')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'medical_certificate')->first()->src }}"
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif
                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="medical_certificate" class="form-control mb-3"
                                            id="photo" type="file">
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

                        <div @class(['mb-5'])>
                            <label class="form-label">CV<x-required /></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'cv')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'cv')->first()->src }}"
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif
                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="cv" class="form-control mb-3" id="photo"
                                            type="file">
                                    @endif
                                </div>
                            @else
                                <input wire:model="cv" class="form-control mb-3" id="photo" type="file">
                            @endif
                            @error('cv')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div @class(['mb-5', 'w-50'])>
                            <label class="form-label">Recommendation Letter from Supervisor<x-required /></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'supervisor_recommendation_letter')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'supervisor_recommendation_letter')->first()->src }}"
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif
                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="supervisor_recommendation_letter" class="form-control mb-3"
                                            id="letter" type="file">
                                    @endif
                                </div>
                            @else
                                <input wire:model="supervisor_recommendation_letter" class="form-control mb-3"
                                    id="letter" type="file">
                            @endif
                            @error('supervisor_recommendation_letter')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    @if ($vacancy->type == 'Experience')
                        <div>
                            <label class="form-label">NOC <x-gray>( From current employer, if already employed
                                    )</x-gray></label>
                            @if ($application)
                                <div>
                                    @if ($application->applicationFiles->where('type', 'noc')->first())
                                        <a href="{{ $application->applicationFiles->where('type', 'noc')->first()->src }}"
                                            style="color:#00ab41">File Link</a>
                                    @else
                                        <x-gray>No Attachment</x-gray>
                                    @endif
                                    @if ($is_resubmission)
                                        <x-gray>(Add to replace file)</x-gray>
                                        <input wire:model="noc" class="form-control mb-3" id="noc"
                                            type="file">
                                    @endif
                                </div>
                            @else
                                <input wire:model="noc" class="form-control mb-3" id="noc" type="file">
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
            ($application && $vacancy->type == 'Assistant Level') ||
            ($application && $vacancy->type == 'Internal') ||
            (!$application &&
                ($vacancy->type == 'External' ||
                    $vacancy->type == 'Internal' ||
                    $vacancy->type == 'Assistant Level') &&
                $current_page == 2)
        ),
    ])>
        <div class="card">
            <h5 class="card-header bg-white">Class X Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_x_school_name" type="text" class="form-control"
                            id="floatingClassXSchoolName" placeholder=""
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label for="floatingClassXSchoolName">School Name<x-required /></label>
                        @error('class_x_school_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_x_completion_year" type="number" class="form-control"
                            id="floatingClassXCompletionYear" placeholder=""
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label for="floatingClassXCompletionYear">Completion Year<x-required /></label>
                        @error('class_x_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="formFileLg" class="form-label">Class X Marksheet<x-required /> <span
                            style="opacity: 0.5;">(pdf,jpeg,png,jpg
                            Max:1mb)</span></label>
                    @if ($application)
                        <div>
                            @if ($application->applicationFiles->where('type', 'class_x_marksheet')->first())
                                <a href="{{ $application->applicationFiles->where('type', 'class_x_marksheet')->first()->src }}"
                                    style="color:#00ab41">File Link</a>
                            @else
                                <x-gray>No Attachment</x-gray>
                            @endif
                            @if ($is_resubmission)
                                <x-gray>(Add to replace file)</x-gray>
                                <input wire:model="class_x_marksheet" class="form-control" id="formFileLg"
                                    type="file">
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
                <h5 class="card-title">Marks<x-required /></h5>
                <ul>
                    <li>Pecentage is calculated based on English + 4 best subjects.</li>
                    <li>Leave the field for a subject empty if you have not taken the subject.</li>
                </ul>

                @if ($state == 'editing' || $is_resubmission)
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
            ($application && $vacancy->type == 'Assistant Level') ||
            ($application && $vacancy->type == 'Internal') ||
            (!$application &&
                ($vacancy->type == 'External' ||
                    $vacancy->type == 'Assistant Level' ||
                    $vacancy->type == 'Internal') &&
                $current_page == 3)
        ),
    ])>
        <div class="card">
            <h5 class="card-header bg-white">Class XII Details</h5>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_xii_school_name" type="text" class="form-control" placeholder=""
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label>School Name<x-required /></label>
                        @error('class_xii_school_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="class_xii_completion_year" type="number" class="form-control"
                            placeholder="" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label>Completion Year<x-required /></label>
                        @error('class_xii_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="form-label">Class XII Marksheet<x-required /> <span
                            style="opacity: 0.5;">(pdf,jpeg,png,jpg
                            Max:1mb)</span></label>
                    @if ($application)
                        <div>
                            @if ($application->applicationFiles->where('type', 'class_xii_marksheet')->first())
                                <a href="{{ $application->applicationFiles->where('type', 'class_xii_marksheet')->first()->src }}"
                                    style="color:#00ab41">File Link</a>
                            @else
                                <x-gray>No Attachment</x-gray>
                            @endif
                            @if ($is_resubmission)
                                <x-gray>(Add to replace file)</x-gray>
                                <input wire:model="class_xii_marksheet" class="form-control" type="file">
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
                <h5 class="card-title">Marks<x-required /></h5>
                <ul>
                    <li>Pecentage is calculated based on English + 3 best subjects.</li>
                    <li>Leave the field for a subject empty if you have not taken the subject.</li>
                </ul>

                @if ($state == 'editing' || $is_resubmission)
                    <livewire:stream-input :marks="$application ? $application->class_xii_marks : $class_xii_marks" :average="$application ? $application->class_xii_avg : $class_xii_avg" :stream="$class_xii_stream" :disabled_stream="true" />
                @else
                    <livewire:stream-input :marks="$application ? $application->class_xii_marks : $class_xii_marks" :average="$application ? $application->class_xii_avg : $class_xii_avg" :disabled="$application ? true : false" :disabled_stream="$application ? true : false"
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
            $application ||
            (!$application &&
                ($vacancy->type == 'External' ||
                    $vacancy->type == 'Assistant Level' ||
                    $vacancy->type == 'Internal') &&
                $current_page == 4) ||
            (!$application && $vacancy->type == 'Experience' && $current_page == 2)
        ),
    ])>
        <div class="card" style="margin-bottom: 20px;">
            <h5 class="card-header bg-white">Degree/Diploma/VTI Details</h5>
            <div class="card-body">
                @if ($vacancy->type == 'Assistant Level' || $vacancy->type == 'Internal')
                    <div class="mb-4">
                        <input wire:model.live="degree_completed" type="checkbox" wire:change="onPercentageChanged"
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif
                            @if ($application && $degree_completed) checked @endif>
                        Degree Completed
                    </div>
                @endif
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="form-floating flex-grow-1">
                        @if ($vacancy->type == 'External' || $vacancy->type == 'Experience' )
                            <input wire:model="university_or_college_name" type="text" class="form-control"
                                placeholder="" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                            <label>University/College Name<x-required /></label>
                        @else
                            <input wire:model="university_or_college_name" type="text" class="form-control"
                                placeholder="" @if (
                                    (!$application && !$degree_completed) ||
                                        !(
                                            !$application ||
                                            ($state == 'editing' && $degree_completed) ||
                                            (($is_resubmission && $vacancy->type == 'Experience') ||
                                                ($is_resubmission && $vacancy->type == 'Assistant Level' && $degree_completed) || ($is_resubmission && $vacancy->type == 'Internal' && $degree_completed))
                                        )) disabled @endif>
                            <label>University/College Name<x-required /></label>
                        @endif
                        @error('university_or_college_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        @if ($vacancy->type == 'External'  || $vacancy->type == 'Experience' )
                            <input wire:model="university_or_college_course_name" type="text" class="form-control"
                                placeholder="" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        @else
                            <input wire:model="university_or_college_course_name" type="text" class="form-control"
                                placeholder="" @if (
                                    (!$application && !$degree_completed) ||
                                        !(
                                            !$application ||
                                            ($state == 'editing' && $degree_completed) ||
                                            (($is_resubmission && $vacancy->type == 'Experience') ||
                                                ($is_resubmission && $vacancy->type == 'Assistant Level' && $degree_completed) || ($is_resubmission && $vacancy->type == 'Internal' && $degree_completed))
                                        )) disabled @endif>
                        @endif
                        <label>Course Name<x-required /></label>
                        @error('university_or_college_course_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        @if ($vacancy->type == 'External'  || $vacancy->type == 'Experience' )
                            <input wire:model="university_or_college_completion_year" type="number"
                                class="form-control" placeholder=""
                                @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        @else
                            <input wire:model="university_or_college_completion_year" type="number"
                                class="form-control" placeholder=""
                                @if (
                                    (!$application && !$degree_completed) ||
                                        !(
                                            !$application ||
                                            ($state == 'editing' && $degree_completed) ||
                                            (($is_resubmission && $vacancy->type == 'Experience') ||
                                                ($is_resubmission && $vacancy->type == 'Assistant Level' && $degree_completed) || ($is_resubmission && $vacancy->type == 'Internal' && $degree_completed))
                                        )) disabled @endif>
                        @endif
                        <label>Completion Year<x-required /></label>
                        @error('university_or_college_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="flex-grow-1">
                        <label class="form-label">Percentage<x-required /></label>
                        @if ($vacancy->type == 'External' || $vacancy->type == 'Experience' )
                            <input wire:model="university_or_college_percentage" wire:change="onPercentageChanged"
                                type="number" class="form-control" step="0.01"
                                @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        @else
                            <input wire:model="university_or_college_percentage" wire:change="onPercentageChanged"
                                type="number" class="form-control" step="0.01"
                                @if (
                                    (!$application && !$degree_completed) ||
                                        !(
                                            !$application ||
                                            ($state == 'editing' && $degree_completed) ||
                                            (($is_resubmission && $vacancy->type == 'Experience') ||
                                                ($is_resubmission && $vacancy->type == 'Assistant Level' && $degree_completed) || ($is_resubmission && $vacancy->type == 'Internal' && $degree_completed))
                                        )) disabled @endif>
                        @endif
                        @error('university_or_college_percentage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label">Degree/Diploma/VTI Marksheet<x-required /><span
                                style="opacity: 0.5;"> (pdf,jpeg,png,jpg
                                Max:1mb)</span></label>
                        @if ($application)
                            <div>
                                @if ($application->applicationFiles->where('type', 'university_or_college_marksheet')->first())
                                    <a href="{{ $application->applicationFiles->where('type', 'university_or_college_marksheet')->first()->src }}"
                                        style="color:#00ab41">File Link</a>
                                @else
                                    <x-gray>No Attachment</x-gray>
                                @endif
                                @if ($is_resubmission)
                                    <x-gray>(Add to replace file)</x-gray>
                                    <input wire:model="university_or_college_marksheet" class="form-control"
                                        type="file">
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

        @if ($vacancy->type == 'External' || $vacancy->type == 'Assistant Level' || $vacancy->type == 'Internal')
            <div class="card text-center">
                <div class="card-header bg-white">
                    Final Score <span style="opacity: 0.5; user-select: none;">
                        @if ($vacancy->type == 'External')
                            (30 - 30 - 40 Ratio)
                        @else
                            (50 - 50 Ratio)
                        @endif
                    </span>
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
                            placeholder="" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label>Masters Institution Name<x-required /></label>
                        @error('masters_institution_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="masters_course_name" type="text" class="form-control" placeholder=""
                            @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label>Course Name<x-required /></label>
                        @error('masters_course_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating flex-grow-1">
                        <input wire:model="masters_completion_year" type="number" class="form-control"
                            placeholder="" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        <label>Completion Year<x-required /></label>
                        @error('masters_completion_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-3 mb-3">
                    <div class="flex-grow-1">
                        <label class="form-label">Percentage<x-required /></label>
                        <input wire:model="masters_percentage" wire:change="onPercentageChanged" type="number"
                            class="form-control" step="0.01" @if (!(!$application || $state == 'editing' || $is_resubmission)) disabled @endif>
                        @error('masters_percentage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex-grow-1">
                        <label class="form-label">Masters Marksheet<x-required /><span style="opacity: 0.5;">
                                (pdf,jpeg,png,jpg
                                Max:1mb)</span></label>
                        @if ($application)
                            <div>
                                @if ($application->applicationFiles->where('type', 'masters_marksheet')->first())
                                    <a href="{{ $application->applicationFiles->where('type', 'masters_marksheet')->first() }}"
                                        style="color:#00ab41">File Link</a>
                                @else
                                    <x-gray>No Attachment</x-gray>
                                @endif
                                @if ($is_resubmission)
                                    <x-gray>(Add to replace file)</x-gray>
                                    <input wire:model="masters_marksheet" class="form-control" type="file">
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
                    Final Score <span style="opacity: 0.5; user-select: none;">(50 - 50 Ratio)</span>
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
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#agreeModal"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Submit</button>
                <!-- Modal -->
                <div class="modal fade" id="agreeModal" tabindex="-1" aria-labelledby="agreeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="agreeModalLabel">Terms and Conditions</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    By submitting this job application, you acknowledge and agree to the following terms
                                    and conditions:
                                </p>
                                <ul>
                                    <li>
                                        <strong>Accuracy of Information:</strong> You certify that all information
                                        provided in this application is true and complete to the best of your knowledge.
                                        Any false statements or omissions may disqualify you from consideration or
                                        result in termination if discovered later.
                                    </li>
                                    <li>
                                        <strong>Data Privacy:</strong> Your personal information will be processed and
                                        stored in accordance with our Privacy Policy. We are committed to protecting
                                        your privacy and will not disclose your information to third parties without
                                        your consent, except as required by law.
                                    </li>
                                    <li>
                                        <strong>Consent to Background Checks:</strong> You consent to any background
                                        checks that may be conducted as part of the hiring process, including
                                        verification of employment history, education, and criminal records.
                                    </li>
                                    <li>
                                        <strong>Employment Relationship:</strong> Submitting this application does not
                                        create an employment contract. Any job offer is subject to the company's
                                        policies, procedures, and verification of the information provided.
                                    </li>
                                </ul>
                                <p>
                                    By clicking "Agree" you confirm that you have read, understood, and agreed to
                                    these terms and conditions.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn" data-bs-dismiss="modal"
                                    style="background-color:#00ab41;border:none;color:white;">Agree</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <button type="button" class="btn" wire:click="next"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Next</button>
            @endif
        </div>
    @endif

    @if ($application && $vacancy->status == 'Open' && !$is_resubmission)
        <div>
            @error('rejection_remarks')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror
            <div wire:loading class="spinner-border text-success" role="status">
            </div>
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#rejectModal"
                style="background-color:red;border:none;color:white;padding:7px 40px;border-radius:2px;">Reject
                Application</button>
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="agreeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="agreeModalLabel">Reject Application</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="exampleFormControlTextarea1" class="form-label">Remarks</label>
                            <textarea wire:model="rejection_remarks" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">`
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" wire:click="reject" class="btn" data-bs-dismiss="modal"
                                style="background-color:red;border:none;color:white;">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($is_resubmission)
        <div class="d-flex justify-content-center justify-content-md-between">
            <div></div>
            <div wire:loading class="spinner-border text-success" role="status">
            </div>
            <button type="button" class="btn" wire:click="edit"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Resubmit</button>
        </div>
    @endif
</form>
