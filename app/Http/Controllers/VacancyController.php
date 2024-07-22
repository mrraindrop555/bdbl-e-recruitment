<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Closure;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        return view('Index', [
            'vacancies' => Vacancy::with('attachment')
                ->whereNot('status', 'Shortlisted')
                ->get()
        ]);
    }

    public function show(Vacancy $vacancy)
    {
        return view(
            'Detail',
            [
                'vacancy' => $vacancy
            ]
        );
    }

    public function apply(Vacancy $vacancy)
    {
        return view(
            'Application',
            [
                'vacancy' => $vacancy
            ]
        );
    }

    public function result()
    {
        return view(
            'Result',
            [
                'vacancies' => Vacancy::withCount('applications')
                    ->where('status', 'Shortlisted')
                    ->get(),
            ]
        );
    }
}
