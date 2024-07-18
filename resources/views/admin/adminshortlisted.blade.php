<x-layouts.admin>
    <form action="{{ "/admin/vacancy/{$vacancy->id}/shortlist" }}" method="POST" class="table-container">
        @csrf
        <h4>Job vacancy ({{ $vacancy->status }})</h4>
        <div style="margin-bottom:20px">
            Individuals selected for their respective positions have been listed accordingly
        </div>

        <div style="margin-bottom:20px">
            Benchmark: {{ $vacancy->benchmark }}
        </div>
        <div class="d-flex justify-content-between mb-4">
            <a href="/admin" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancy</a>
            @if ($vacancy->status == 'Closed')
                <button type="submit" class="btn"
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
                    <th scope="col">CID</th>
                    <th scope="col">Mark Secured</th>
                    <th scope="col">status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr class="text-center">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $application->cid }}</td>
                        <td class="text-center">{{ $application->marks }}</td>
                        <td class="text-center">
                            @if ($vacancy->status == 'Open')
                                <span>Pending</span>
                            @elseif ($vacancy->status == 'Closed')
                                <input type="checkbox" name="shortlisted[]" value="{{ $application->id }}"
                                    @if ($application->marks >= $vacancy->benchmark) checked @endif style="margin-right: 10px;">
                                <span style="flex: none;">Selected</span>
                            @elseif ($vacancy->status == 'Shortlisted' && $application->is_selected)
                                <span class='text-success'>Selected</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</x-layouts.admin>
