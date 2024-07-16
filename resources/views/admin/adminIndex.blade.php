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
            <form action="/logout" method="POST" class="d-flex  mr-lg-5">
                @csrf
                <button class="btn" type="submit"
                    style="background-color:#fff;border:none;color:#00ab41;padding:7px 40px;border-radius:2px;">Logout</button>
            </form>
        </div>
    </nav>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <h4>Job vacancy</h4>
        <div style="margin-bottom:20px">
            The Management of Bhutan Development Bank (BDB) would like to announce vacancy for the position indicated
            below in the table:
        </div>

        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="/adminresult" class="btn"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">View
                    result</a>
            </div>
            <div>
                <a href="/adminresult" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Add
                    vacancy</a>
            </div>
        </div>


        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Position Title</th>
                    <th scope="col">Slot</th>
                    <th scope="col">Employment Type & Grade</th>
                    <th>Attachments</th>
                    <th>Status</th>
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
                            @if ($vacancy->is_open)
                                <span class=text-success>Open</span>
                            @else
                                <span class=text-danger>Closed</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ "/admin/vacancy/{$vacancy->id}" }}" style="text-decoration: none;color:#00ab41">More
                                Details</a>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Position Title</label>
                                <input type="text" name="position_title" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Number of slots</label>
                                <input type="number" name="number_of_slots" min="1" class="form-control"
                                    id="inputPassword4">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Employment Type & Grade</label>
                                <div id="input-list-1">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="employment_type[]">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger remove-btn" type="button">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="add-input-1">Add More</button>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Qualification & Criteria</label>
                                <div id="input-list-2">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="qualifications[]">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger remove-btn" type="button">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="add-input-2">Add More</button>
                            </div>
                            <div class="col-md-12">
                                <label for="inputAddress2" class="form-label">Salary & Other Benefits</label>
                                <div id="input-list-3">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="salary_and_benefits[]">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger remove-btn" type="button">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="add-input-3">Add More</button>
                            </div>
                            <div class="my-4">
                                <input class="form-control" type="file" id="formFile">
                            </div>

                            <div class="modal-footer">
                                <a href="/adminresult" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    style="background-color:red;border:none;color:white;padding:7px 40px;border-radius:2px;">close</a>
                                <a href="/adminresult" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#add-input-1').click(function() {
            let inputHtml = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="employment_type[]">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-btn" type="button">Remove</button>
                    </div>
                </div>`;
            $('#input-list-1').append(inputHtml);
        });

        $('#add-input-2').click(function() {
            let inputHtml = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="qualifications[]">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-btn" type="button">Remove</button>
                    </div>
                </div>`;
            $('#input-list-2').append(inputHtml);
        });

        $('#add-input-3').click(function() {
            let inputHtml = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="salary_and_benefits[]">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-btn" type="button">Remove</button>
                    </div>
                </div>`;
            $('#input-list-3').append(inputHtml);
        });

        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.input-group').remove();
        });
    });
</script>

</html>
