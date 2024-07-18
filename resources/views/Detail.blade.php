<x-layouts.guest>
    <section class="vh-100">
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
                                    <a href="{{ "/vacancy/{$vacancy->id}/apply" }}"
                                        style="background-color:#00ab41;border:none;color:white;padding:6px 60px;border-radius:2px;font-size: 14px;">Apply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</x-layouts.guest>
