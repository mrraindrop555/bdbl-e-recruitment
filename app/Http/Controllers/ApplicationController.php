<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\VacancyApplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function index(Vacancy $vacancy)
    {
        return view('shortlisted', [
            'vacancy' => $vacancy,
            'applications' => $vacancy->applications()
                ->where('is_selected', true)
                ->get()
        ]);
    }

    public function store(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) use ($vacancy) {
                return $query->where('vacancy_id', $vacancy->id);
            })],
            'email' => 'required|email',
            'marks' => 'required|integer',
        ]);

        DB::transaction(function () use ($validated, $vacancy) {
            $application = new Application([...$validated, 'is_selected' => false]);
            $vacancy->applications()->save($application);

            Notification::send(User::all(), new VacancyApplied($application));
        });

        return redirect('/vacancy')->with('success', 'Applied successfully!');
    }
}
