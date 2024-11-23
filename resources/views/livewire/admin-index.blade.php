<div>
    <div class="table-container">
        <h4>Job Vacancy</h4>
        <div style="margin-bottom:20px">
            The Management of Bhutan Development Bank (BDB) would like to announce vacancy for the position indicated
            below in the table.
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="/admin/result" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">View
                    Results</a>
            </div>
            <div>
                <a href="/admin/vacancy/create" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Add
                    Vacancy</a>
            </div>
        </div>

        <div>
            <select wire:model.live="sort">
                <option>Non Archived</option>
                <option>Archived</option>
            </select>
        </div>

        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Position Title</th>
                    <th scope="col">Type</th>
                    <th scope="col">Slot</th>
                    <th scope="col" class="d-none d-md-table-cell">Employment Type & Grade</th>
                    <th class="d-none d-md-table-cell">Attachment</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacancies as $vacancy)
                    @if (($sort == 'Non Archived' && $vacancy->status != "Archived") || ($sort == 'Archived' && $vacancy->status == "Archived"))
                        <tr>
                            <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                            <td><x-job-title :vacancy="$vacancy" /></td>
                            <td>{{ $vacancy->type }}</td>
                            <td class="text-center">{{ $vacancy->number_of_slots }}</td>
                            <td class="d-none d-md-table-cell">
                                <ul>
                                    @foreach ($vacancy->employment_type as $value)
                                        <li>{{ $value }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                @if ($vacancy->attachment)
                                    <a href="{{ $vacancy->attachment->src }}" style="color:#00ab41">Download TOR</a>
                                @else
                                    No Attachment
                                @endif
                            </td>
                            <td>
                                <a href="{{ "/admin/vacancy/{$vacancy->id}" }}"
                                    style="text-decoration: none;color:#00ab41">More
                                    Details</a>
                            </td>
                            <td class="text-center">
                                @if ($vacancy->status != 'Shortlisted' && $vacancy->status != 'Archived')
                                    <a href="/admin/vacancy/{{ $vacancy->id }}/edit">
                                        <img src="{{ asset('assets/edit.png') }}" height="25" style="opacity: 0.7;">
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach


            </tbody>
        </table>

        {{-- <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/vacancy" method="POST" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Position Title</label>
                                <input type="text" name="position_title" value="{{ old('position_title') }}"
                                    class="form-control" id="inputEmail4">
                                @error('position_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Number of slots</label>
                                <input type="number" name="number_of_slots" value="{{ old('number_of_slots') }}"
                                    min="1" class="form-control" id="inputPassword4">
                                @error('number_of_slots')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="inputPassword4" class="form-label">Benchmark</label>
                                <input type="number" name="benchmark" value="{{ old('benchmark') }}" min="1"
                                    class="form-control" id="inputPassword4">
                                @error('benchmark')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <x-multi-input id="m1" name="employment_type" title="Employment Type & Grade" />
                            </div>
                            <div class="col-12">
                                <x-multi-input id="m2" name="qualifications" title="Qualification & Criteria" />
                            </div>
                            <div class="col-md-12">
                                <x-multi-input id="m3" name="salary_and_benefits"
                                    title="Salary & Other Benefits" />
                            </div>
                            <div class="my-4">
                                <input class="form-control" type="file" name="attachment"
                                    value="{{ old('attachment') }}" id="formFile">
                                @error('attachment')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <a class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    style="background-color:red;border:none;color:white;padding:7px 40px;border-radius:2px;">close</a>
                                <button type="submit" class="btn"
                                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            @if ($errors->any())
                <script>
                    $(function() {
                        $('#exampleModal').modal('show');
                    });
                </script>
            @endif
        @endpush --}}
    </div>
</div>
