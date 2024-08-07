<x-layouts.guest>
    <div class="table-container">
        <h4>Job Vacancy</h4>
        <div style="margin-bottom:20px">
            The Management of Bhutan Development Bank (BDB) would like to announce vacancy for the position indicated
            below in the table.
        </div>
        <div class="d-flex  mb-4">
            <a href="/result" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Results</a>
        </div>
        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Position Title</th>
                    <th scope="col" class="d-none d-md-table-cell">Slot</th>
                    <th class="d-none d-md-table-cell">Employment Type & Grade</th>
                    <th class="d-none d-md-table-cell">Attachment</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vacancies as $vacancy)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $vacancy->position_title }}</td>
                        <td class="text-center d-none d-md-table-cell">{{ $vacancy->number_of_slots }}</td>
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
                        <td class="text-center">
                            <a href="{{ "/vacancy/{$vacancy->id}" }}" style="text-decoration: none;color:#00ab41">More
                                Details
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($vacancy->status == 'Open')
                                <a href="{{ "/vacancy/{$vacancy->id}/apply" }}"
                                    style="text-decoration: none;background-color:#00ab41;border:none;color:white;padding:6px 20px;border-radius:2px;font-size: 14px;">Apply</a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-layouts.guest>
