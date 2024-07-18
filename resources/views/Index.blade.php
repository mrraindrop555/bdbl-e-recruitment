<x-layouts.guest>
    <div class="table-container">
        <h4>Job vacancy</h4>
        <div style="margin-bottom:20px">
            The Management of Bhutan Development Bank (BDB) would like to announce vacancy for the position indicated
            below in the table:
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
                    <th scope="col">Slot</th>
                    <th scope="col">Employment Type & Grade</th>
                    <th>Attachments</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($vacancies as $vacancy)
                    <tr>
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $vacancy->position_title }}</td>
                        <td class="text-center">{{ $vacancy->number_of_slots }}</td>
                        <td>
                            <ul>
                                @foreach ($vacancy->employment_type as $value)
                                    <li>{{ $value }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if ($vacancy->attachment)
                                <a href="{{ $vacancy->attachment->src }}" style="color:#00ab41">Download TOR</a>
                            @else
                                No Attachment
                            @endif
                        </td>
                        <td>
                            <a href="{{ "/vacancy/{$vacancy->id}" }}" style="text-decoration: none;color:#00ab41">More
                                Details</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-layouts.guest>
