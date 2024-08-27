<x-layouts.admin>
    <form id="form" action="{{ "/admin/vacancy/{$vacancy->id}/shortlist" }}" method="POST" class="table-container">
        @csrf
        <d class="text-dark" style="font-size: 24px;"><x-job-title :vacancy="$vacancy" big /></d>
        <div style="margin-bottom:20px">
            @if ($vacancy->status == 'Open')
                Close the vacancy to shortlist applicants <span style="opacity: 0.5;">(Edit Vacancy)</span>
            @endif
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div class="d-flex gap-3">
                <a href="/admin" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                    Vacancies</a>
                <div class="dropdown">
                    <a class="btn dropdown-toggle" style="background-color:#00ab41; color:white;" href="#"
                        role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort by
                    </a>
                    @php
                        $sort = request()->query('sort');
                    @endphp
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="?sort=date_asc">Date ascending @if(!$sort || $sort == 'date_asc') <x-check/> @endif</a></li>
                        <li><a class="dropdown-item" href="?sort=date_dsc">Date descending @if($sort == 'date_dsc') <x-check/> @endif</a></li>
                        @if ($vacancy->type != 'Internal')
                            <li><a class="dropdown-item" href="?sort=marks_asc">Marks ascending @if($sort == 'marks_asc') <x-check/> @endif</a></li>
                            <li><a class="dropdown-item" href="?sort=marks_dsc">Marks descending @if($sort == 'marks_dsc') <x-check/> @endif</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            @if ($vacancy->status == 'Closed')
                <button id="shortlist" type="submit" class="btn"
                    onclick="return confirm('Are you sure you want to shortlist applicants?')"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">Shortlist</button>
            @elseif ($vacancy->status == 'Shortlisted')
                <a href="{{ "/admin/vacancy/{$vacancy->id}/download" }}" id="shortlist" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">Download
                    Result</a>
            @endif
        </div>

        @error('shortlisted')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/No</th>
                    <th scope="col">Name</th>
                    <th scope="col">CID</th>
                    <th scope="col">Applied on</th>
                    @if ($vacancy->type != 'Internal')
                        <th scope="col">Mark Secured
                            <br>
                            <x-gray>Benchmark: {{ $vacancy->benchmark }}</x-gray>
                        </th>
                    @endif
                    @if ($vacancy->status != 'Open')
                        <th scope="col"></th>
                    @endif
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr class="text-center">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->cid }}</td>
                        <td>{{ $application->created_at->format('d M Y, h:i A') }}</td>
                        @if ($vacancy->type != 'Internal')
                            <td class="text-center">{{ $application->final_score }}</td>
                        @endif
                        <td>
                            <a href="{{ "/admin/application/{$application->id}" }}"
                                style="text-decoration: none;color:#00ab41">View
                                Application</a>
                        </td>
                        @if ($vacancy->status != 'Open')
                            <td>
                                @if ($vacancy->status == 'Closed')
                                    <input type="checkbox" name="shortlisted[]" value="{{ $application->id }}"
                                        @if ($vacancy->type != 'Internal' && $application->final_score >= $vacancy->benchmark) checked @endif style="margin-right: 10px;">
                                @elseif ($vacancy->status == 'Shortlisted' && $application->is_shortlisted)
                                    <span class='text-secondary fw-bold'>Shortlisted</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#form').submit(function(event) {
                    $("#shortlist").prop('disabled', true);
                    return true;
                });
            });
        </script>
    @endpush
</x-layouts.admin>
