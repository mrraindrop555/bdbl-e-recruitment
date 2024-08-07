<x-layouts.admin>
    <form id="form" action="{{ "/admin/vacancy/{$vacancy->id}/shortlist" }}" method="POST" class="table-container">
        @csrf
        <d class="text-dark" style="font-size: 24px;"><x-job-title :vacancy="$vacancy" big /></d>
        <div style="margin-bottom:20px">
            @if ($vacancy->status == 'Open')
                Close the vacancy to shortlist applicants <span style="opacity: 0.5;">(Edit Vacancy)</span>
            @endif
        </div>

        <div style="margin-bottom:20px">
            Benchmark: {{ $vacancy->benchmark }}
        </div>
        <div class="d-flex justify-content-between mb-4">
            <a href="/admin" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a>
            @if ($vacancy->status == 'Closed')
                <button id="shortlist" type="submit" class="btn"
                    onclick="return confirm('Are you sure you want to shortlist applicants?')"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">Shortlist</button>
            @endif
        </div>

        @error('shortlisted')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Name</th>
                    <th scope="col">CID</th>
                    <th scope="col">Mark Secured</th>
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
                        <td class="text-center">{{ $application->final_score }}</td>
                        <td>
                            <a href="{{ "/admin/application/{$application->id}" }}"
                                style="text-decoration: none;color:#00ab41">View
                                Application</a>
                        </td>
                        @if ($vacancy->status != 'Open')
                            <td>
                                @if ($vacancy->status == 'Closed')
                                    <input type="checkbox" name="shortlisted[]" value="{{ $application->id }}"
                                        @if ($application->final_score >= $vacancy->benchmark) checked @endif style="margin-right: 10px;">
                                @elseif ($vacancy->status == 'Shortlisted' && $application->is_shortlisted)
                                    <span class='text-secondary fw-bold'>SELECTED</span>
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
