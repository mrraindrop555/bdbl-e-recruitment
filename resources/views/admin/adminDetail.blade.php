<x-layouts.admin>
    <section>
        <div class="container-fluid py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-lg-10 mb-4 mb-lg-0">
                    <div class="card mb-3 px-2 px-md-5" style="border-radius: .5rem;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-dark" style="font-size: 24px;"><x-job-title :vacancy="$vacancy" big />
                                </h6>
                                {{-- @if ($vacancy->status != 'Shortlisted')
                                    <a href="/admin/vacancy/{{ $vacancy->id }}/edit">
                                        <img src="{{ asset('assets/edit.png') }}" height="30" style="opacity: 0.7;">
                                    </a>
                                @endif --}}
                            </div>

                            <hr class="mt-0 mb-2">
                            <div class="mb-3 d-flex gap-3">
                                <span>Type: {{ $vacancy->type }}</span>
                                <div>|</div>
                                <span>{{ $vacancy->number_of_slots }} Slots</span>
                                <div>|</div>
                                <div>
                                    Close datetime:
                                    {{ date('M j, Y, g:i a', strtotime($vacancy->date_time)) }} <span
                                        style="opacity: 0.5; user-select: none;">({{ $vacancy->closure }})</span>
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
                                <div class="col-12 mb-1 text-dark" style="font-size: 14px;line-height:1.5rem">
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
                                <div class="col-12 mb-1" style="font-size: 14px;line-height: 1.5rem;">
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
                                <div class="col-12 mb-4 text-dark" style="font-size: 14px;line-height:1.5rem">
                                    <h6>Gross Salary & other benefits</h6>
                                    @foreach ($vacancy->salary_and_benefits as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </div>
                            </div>
                            {{-- <a href="/result" class="btn mt-2"
                                style="background-color:#00ab41;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">Edit</a> --}}
                            <form class="d-inline" method="POST" action="{{ "/admin/vacancy/{$vacancy->id}" }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this?')"
                                    class="btn mt-2"
                                    style="background-color:red;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">Delete</button>
                            </form>
                            {{-- @if ($vacancy->status != 'Shortlisted')
                                <form class="d-inline" method="POST"
                                    action="{{ "/admin/vacancy/{$vacancy->id}/toggle" }}">
                                    @csrf
                                    <button type="submit" class="btn mt-2"
                                        style="background-color:gray;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">
                                        @if ($vacancy->status == 'Open')
                                            Close
                                        @else
                                            Open
                                        @endif
                                    </button>
                                </form>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
    </section>
    </x-layouts.guest>
