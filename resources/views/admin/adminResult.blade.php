<!DOCTYPE html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                <a href="/adminresult" class="btn" style="background-color:#fff;border:none;color:#00ab41;padding:7px 40px;border-radius:2px;">Logout</a>
            </div>
        </div>
    </nav>
    <div class="table-container">
        <h4>Job vacancy</h4>
        <div style="margin-bottom:20px">
            Individuals selected for their respective positions have been listed accordingly:
        </div>
        <div class="d-flex  mb-4">
            <a href="/admin" class="btn" style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View Vacancy</a>
        </div>
        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">Position Title</th>
                    <th scope="col">No. of Applicants</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td scope="row">1</td>
                    <td> General Manager ICT & Digital Banking Division</td>
                    <td class="text-center">54</td>

                    <td>
                        <a href="/adminshortlisted" class="btn" style="background-color:#00ab41;border:none;color:white;padding:5px 30px;border-radius:2px">View Applicants</a>
                    </td>
                </tr>

                <tr class="text-center">
                    <td scope="row">2</td>
                    <td> Software Developer</td>
                    <td class="text-center">60</td>
                    <td>
                        <a href="/adminshortlisted" class="btn" style="background-color:#00ab41;border:none;color:white;padding:5px 30px;border-radius:2px">View Applicants</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>