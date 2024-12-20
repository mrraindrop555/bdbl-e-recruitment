<x-layouts.admin>
    <div class="table-container">
        <h4>Job Result</h4>
        <div style="margin-bottom:20px">
            Individuals selected for their respective positions have been listed accordingly
        </div>
        <div class="d-flex  mb-4">
            <a href="/admin" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px">View
                Vacancies</a>
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
                @foreach ($vacancies as $vacancy)
                    <tr class="text-center">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td><x-job-title :vacancy="$vacancy"/></td>
                        <td class="text-center">{{ $vacancy->applications_count }}</td>
                        <td>
                            <a href="{{ "/admin/result/{$vacancy->id}" }}" class="btn"
                                style="background-color:#00ab41;border:none;color:white;padding:5px 30px;border-radius:2px">View
                                Applicants</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.admin>
