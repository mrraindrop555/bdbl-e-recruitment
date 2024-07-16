<!DOCTYPE html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>

<body style="background-color: #f4f5f7;">
    <nav class="navbar" style="background-color:#00ab41">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex">
                <img src="{{ asset('assets/Logo.png') }}" alt="Description" class="logo">
                <h5 class="d-none d-sm-block my-auto" style="color:white;">Bhutan Development Bank Limited</h5>
            </a>
            <div class="d-flex  mr-lg-5">
                <img src="{{ asset('assets/profile.jpg') }}" alt="Description" width="50" height="50"
                    style="border-radius:100px;">
            </div>
        </div>
    </nav>
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

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
