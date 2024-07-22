<x-layouts.guest>
    <div class="table-container">
        <h6 class="text-dark" style="font-size: 24px;"><x-job-title :vacancy="$vacancy" big /></h6>
        <div style="margin-bottom:20px">
            Individuals selected for their respective positions have been listed accordingly.
        </div>
        <div class="d-flex  mb-4">
            <a href="/" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancy</a>
        </div>
        <table class="table table-bordered" style="color: #212122;">
            <thead>
                <tr class="text-center">
                    <th scope="col">Sl/no</th>
                    <th scope="col">CID</th>
                    {{-- <th scope="col">Mark Secured</th> --}}
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr class="text-center">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $application->cid }}</td>
                        {{-- <td class="text-center">{{ $application->marks }}</td> --}}
                        <td class="text-center">
                            <span class='text-secondary fw-bold'>SELECTED</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.guest>
