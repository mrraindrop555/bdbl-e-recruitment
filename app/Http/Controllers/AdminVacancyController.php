<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Attachment;
use App\Models\Vacancy;
use App\Notifications\ShortlistResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVacancyController extends Controller
{
    public function index()
    {
        return view('admin/adminindex', [
            'vacancies' => Vacancy::with('attachment')
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position_title' => 'required',
            'number_of_slots' => 'required|integer',
            'benchmark' => 'required|decimal:0,2',
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
            $vacancy = Vacancy::create([...$request->except(['attachment']), 'status' => 'Open']);
            if ($request->hasFile('attachment')) {
                $path = $validated['attachment']->store('attachments', 'public');
                $vacancy->attachment()->save(new Attachment(['filename' => $path]));
            }
        });

        return redirect()->back()->with('success', 'Vacancy created successfuly!');
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

    public function shortlist(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'shortlisted' => 'required|array'
        ]);

        DB::transaction(function () use ($validated, $vacancy) {
            foreach ($validated['shortlisted'] as $id) {
                Application::find($id)->update(['is_selected' => true]);
            }

            $vacancy->applications()->each(function ($application) {
                $application->notify(new ShortlistResult($application));
            });

            $vacancy->update(['status' => 'Shortlisted']);
        });

        return back()->with('success', 'Shortlisted successfully!');
    }
}
