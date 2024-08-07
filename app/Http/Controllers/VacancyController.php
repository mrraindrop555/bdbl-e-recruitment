<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        return view('Index', [
            'vacancies' => Vacancy::with('attachment')
                ->where('status', 'Open')
                ->whereIn('type', ['External', 'Experience'])
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
                    ->whereNot('status', 'Open')
                    ->get(),
            ]
        );
    }
}
