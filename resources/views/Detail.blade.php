<x-layouts.guest>
    <section>
        <div class="container-fluid py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-lg-10 mb-4 mb-lg-0">
                    <div class="card mb-3 px-2 px-md-5" style="border-radius: .5rem;">
                        <div class="card-body p-4">
                            <h6 class="text-dark" style="font-size: 24px;">{{ $vacancy->position_title }}</h6>
                            <hr class="mt-0 mb-2">
                            <div class="mb-3 d-flex gap-3">
                                <span>{{ $vacancy->number_of_slots }} Slots</span>
                                <div>|</div>
                                <div>
                                    Close datetime:
                                    {{ date('M j, Y, g:i a', strtotime($vacancy->date_time)) }}
                                </div>
                                <div>|</div>
                                <div>
                                    @if ($vacancy->attachment)
                                        <a href="{{ $vacancy->attachment->src }}" style="color:#00ab41">Download TOR</a>
                                    @else
                                        No Attachment
                                    @endif
                                </div>
                            </div>
                            <div class="row pt-1">
                                <div class="col-12 mb-3 text-dark" style="font-size: 14px;line-height:1.5rem">
                                    <h6>Employment Type and Grade </h6>
                                    <p class="text-muted">
                                        @foreach ($vacancy->employment_type as $value)
                                            <li>{{ $value }}</li>
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col-12 mb-3" style="font-size: 14px;line-height: 1.5rem;">
                                    <h6>Qualification & Criteria </h6>
                                    <p class="text-muted">
                                        @foreach ($vacancy->qualifications as $value)
                                            <li>{{ $value }}</li>
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col-12 mb-3 text-dark" style="font-size: 14px;line-height:1.5rem">
                                    <h6>Gross Salary & other benefits</h6>
                                    @foreach ($vacancy->salary_and_benefits as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col-12 mb-3 text-dark" style="font-size: 14px;line-height:1.5rem">
                                    <h6 class="text-danger">Required Documents</h6>

                                    <div class="text-danger">
                                        @if ($vacancy->type == 'External')
                                            <li>Passport size photo</li>
                                            <li>Citizenship Identity Card</li>
                                            <li>Security Clearance Certificate</li>
                                            <li>Medical Certificate</li>
                                            <li>CV</li>
                                            <li>Class X Marksheet</li>
                                            <li>Class XII Marksheet</li>
                                            <li>Degree/Diploma/VTI Marksheet</li>
                                        @elseif ($vacancy->type == 'Internal')
                                            <li>CV</li>
                                        @elseif ($vacancy->type == 'Experience')
                                            <li>Passport size photo</li>
                                            <li>Citizenship Identity Card</li>
                                            <li>Security Clearance Certificate</li>
                                            <li>Medical Certificate</li>
                                            <li>CV</li>
                                            <li>NOC ( If already employed )</li>
                                            <li>Degree/Diploma/VTI Marksheet</li>
                                            <li>Masters Marksheet</li>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{ "/vacancy/{$vacancy->id}/apply" }}"
                                style="text-decoration: none;background-color:#00ab41;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</x-layouts.guest>
