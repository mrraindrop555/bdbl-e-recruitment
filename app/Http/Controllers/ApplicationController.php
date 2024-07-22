<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\VacancyApplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function index(Vacancy $vacancy)
    {
        Gate::allowIf(fn () => $vacancy->status == 'Shortlisted');

        return view('shortlisted', [
            'vacancy' => $vacancy,
            'applications' => $vacancy->applications()
                ->where('is_shortlisted', true)
                ->get()
        ]);
    }

    public function store(Request $request, Vacancy $vacancy)
    {
        Gate::allowIf(fn () => $vacancy->status == 'Open');

        $validated = $request->validate([
            'name' => 'required',
            'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) use ($vacancy) {
                return $query->where('vacancy_id', $vacancy->id);
            })],
            'email' => 'required|email',
            'class_x_school_name' => 'required',
            'class_x_completion_year' => 'required',
            'class_x_marksheet' => 'required|file|max:5120',
            'class_x_marks' => 'required',
            'class_x_avg' => 'required|decimal:0,2',
            'class_xii_school_name' => 'required',
            'class_xii_stream' => 'required',
            'class_xii_completion_year' => 'required',
            'class_xii_marksheet' => 'required|file|max:5120',
            'class_xii_marks' => 'required',
            'class_xii_avg' => 'required|decimal:0,2',
            'final_score' => 'required|decimal:0,2',
        ]);

        DB::transaction(function () use ($validated, $vacancy, $request) {
            $application = new Application([...$request->except(['class_x_marksheet', 'class_xii_marksheet']), 'is_shortlisted' => false]);
            $vacancy->applications()->save($application);

            if ($request->hasFile('class_x_marksheet')) {
                $path = $validated['class_x_marksheet']->store('attachments', 'public');
                $application->classXMarksheet()->save(new Attachment(['filename' => $path]));
            }

            if ($request->hasFile('class_xii_marksheet')) {
                $path = $validated['class_xii_marksheet']->store('attachments', 'public');
                $application->classXIIMarksheet()->save(new Attachment(['filename' => $path]));
            }

            Notification::send(User::all(), new VacancyApplied($application));
        });

        return redirect('/vacancy')->with('success', 'Applied successfully!');
    }
}
