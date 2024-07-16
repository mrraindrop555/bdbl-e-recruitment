<!DOCTYPE html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>

<body>
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
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container-fluid py-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-lg-10 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0 px-5">
                            <div class="col-md-10">
                                <div class="card-body p-4">
                                    <h6 class="text-dark" style="font-size: 24px;">General Manager ICT & Digital Banking
                                        Division</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3 text-dark" style="font-size: 14px;line-height:1.5rem">
                                            <h6>Employment Type and Grade </h6>
                                            <p class="text-muted">
                                                @foreach ($vacancy->employment_type as $value)
                                                    <li>{{ $value }}</li>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3" style="font-size: 14px;line-height: 1.5rem;">
                                            <h6>Qualification & Criteria </h6>
                                            <p class="text-muted">
                                                @foreach ($vacancy->qualifications as $value)
                                                    <li>{{ $value }}</li>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-3 text-dark" style="font-size: 14px;line-height:1.5rem">
                                            <h6>Gross Salary & other benefits</h6>
                                            @foreach ($vacancy->salary_and_benefits as $value)
                                                <li>{{ $value }}</li>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="/result" class="btn mt-2"
                                        style="background-color:#00ab41;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">Apply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
