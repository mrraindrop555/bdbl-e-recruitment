<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationExport;
use App\Models\Application;
use App\Models\Attachment;
use App\Models\Vacancy;
use App\Notifications\ShortlistResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Facades\Zip;

class AdminVacancyController extends Controller
{
    public function index()
    {
        return view('admin/adminIndex', [
            'vacancies' => Vacancy::with('attachment')
                ->get()
        ]);
    }

    public function create()
    {
        return view('admin.adminAddVacancy');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'position_title' => 'required',
            'number_of_slots' => 'required|integer',
            'benchmark' => 'required|decimal:0,2',
            'close_datetime' => 'required|date',
            'closure' => 'required',
            'employment_type' => 'required|array|min:1',
            'employment_type.*' => 'required',
            'qualifications' => 'required|array|min:1',
            'qualifications.*' => 'required',
            'salary_and_benefits' => 'required|array|min:1',
            'salary_and_benefits.*' => 'required',
            'attachment' => 'nullable|file|max:5120'
        ], [
            'attachment.max' => 'The file must not be greater than 5MB.',
        ]);


        DB::transaction(function () use ($validated, $request) {
            $vacancy = Vacancy::create([...$request->except(['attachment']), 'status' => 'Draft']);
            if ($request->hasFile('attachment')) {
                $path = $validated['attachment']->store('attachments', 'public');
                $vacancy->attachment()->save(new Attachment(['filename' => $path]));
            }
        });

        return redirect('/admin/vacancy')->with('success', 'Vacancy created successfuly!');
    }

    public function show(Request $request, Vacancy $vacancy)
    {
        return view(
            'admin/adminDetail',
            [
                'vacancy' => $vacancy
            ]
        );
    }

    public function edit(Vacancy $vacancy)
    {
        Gate::allowIf(fn () => $vacancy->status != 'Shortlisted' && $vacancy->status != 'Archived');

        return view(
            'admin.adminEditVacancy',
            [
                'vacancy' => $vacancy
            ]
        );
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        Gate::allowIf(fn () => $vacancy->status != 'Shortlisted');

        $validated = $request->validate([
            'type' => 'required',
            'position_title' => 'required',
            'number_of_slots' => 'required|integer',
            'benchmark' => 'required|decimal:0,2',
            'close_datetime' => 'required|date',
            'closure' => 'required',
            'employment_type' => 'required|array|min:1',
            'employment_type.*' => 'required',
            'qualifications' => 'required|array|min:1',
            'qualifications.*' => 'required',
            'salary_and_benefits' => 'required|array|min:1',
            'salary_and_benefits.*' => 'required',
            'attachment' => 'nullable|file|max:5120',
            'delete_attachment' => 'required',
            'status' => 'required_if:closure,Manual'
        ], [
            'attachment.max' => 'The file must not be greater than 5MB.',
        ]);

        DB::transaction(function () use ($validated, $request, $vacancy) {
            if ($validated['closure'] == 'Auto') {
                $vacancy->update([...$request->except(['attachment', 'delete_attachment', 'status'])]);
            } else {
                $vacancy->update([...$request->except(['attachment', 'delete_attachment'])]);
            }

            if ($validated['delete_attachment'] === 'true') {
                $vacancy->attachment?->delete();
            }
            if ($request->hasFile('attachment')) {
                $path = $validated['attachment']->store('attachments', 'public');
                $vacancy->attachment()->save(new Attachment(['filename' => $path]));
            }
        });

        return redirect('/admin/vacancy')->with('success', 'Vacancy updated successfuly!');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect('/admin/vacancy')->with('success', "Vacancy deleted.");
    }

    public function result()
    {
        return view(
            'admin/adminResult',
            [
                'vacancies' => Vacancy::withCount('applications')
                    ->get()
            ]
        );
    }

    public function toggleStatus(Vacancy $vacancy)
    {
        if ($vacancy->status == 'Open') {
            $vacancy->update(['status' => 'Closed']);
        } elseif ($vacancy->status == 'Closed') {
            $vacancy->update(['status' => 'Open']);
        }

        return redirect('/admin/vacancy')->with('success', "Vacancy status has been updated!");
    }

    public function open(Vacancy $vacancy)
    {
        $vacancy->update(['status' => 'Open']);

        return redirect('/admin/vacancy')->with('success', "Vacancy is now open!");
    }

    public function archive(Vacancy $vacancy)
    {
        $vacancy->update(['status' => 'Archived']);

        return redirect('/admin/vacancy')->with('success', "Vacancy status has been updated!");
    }

    public function shortlist(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'shortlisted' => 'required|array'
        ]);

        DB::transaction(function () use ($validated, $vacancy) {
            foreach ($validated['shortlisted'] as $id) {
                Application::find($id)->update(['is_shortlisted' => true]);
            }

            $vacancy->applications()->each(function ($application) {
                $application->notify(new ShortlistResult($application));
            });

            $vacancy->update(['status' => 'Shortlisted']);
        });

        return back()->with('success', 'Shortlisted successfully!');
    }

    public function export(Vacancy $vacancy)
    {
        $path = Storage::path('');
        // dd("{$path}download.zip");
        $zip = Zip::create("{$path}download.zip", true);
        // $zip->close();

        return Excel::download(new ApplicationExport($vacancy), "{$vacancy->position_title} Result.xlsx");
    }
}
