<x-layouts.guest>
    <div class="table-container">
        <h4>Job Result</h4>
        <div style="margin-bottom:20px">
            Individuals selected for their respective positions have been listed accordingly.
        </div>
        <div class="d-flex  mb-4">
            @php
                $type = request()->query('type');
            @endphp
            <a href="{{$type == 'internal' ? '/vacancy?type=internal' : '/vacancy'}}" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a>
        </div>
        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Position Title</th>
                    <th scope="col">No. of Applicants</th>
                    <th scope="col">Shortlist Count</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacancies as $vacancy)
                    <tr class="text-center">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $vacancy->position_title }}</td>
                        <td class="text-center">{{ $vacancy->applications_count }}</td>
                        <td>
                            {{ $vacancy->applications->filter(fn($app) => $app->is_shortlisted)->count() }}
                        </td>
                        <td>
                            @if ($vacancy->status == 'Shortlisted')
                                <a href="{{$type == 'internal' ? "/result/{$vacancy->id}?type=internal" : "/result/{$vacancy->id}"}}"
                                    style="text-decoration: none;color:#00ab41">View Result</a>
                            @else
                                Pending
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.guest>
