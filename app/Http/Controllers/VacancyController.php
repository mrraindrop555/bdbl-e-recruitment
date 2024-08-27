<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $type = request()->query('type');

        if ($type == 'internal') {
            return view('Index', [
                'vacancies' => Vacancy::with('attachment')
                    ->where('status', 'Open')
                    ->whereIn('type', ['Internal'])
                    ->get()
            ]);
        } else {
            return view('Index', [
                'vacancies' => Vacancy::with('attachment')
                    ->where('status', 'Open')
                    ->whereIn('type', ['External', 'Experience', 'Assistant Level'])
                    ->get()
            ]);
        }
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
        $type = request()->query('type');

        if ($type == 'internal') {
            return view(
                'Result',
                [
                    'vacancies' => Vacancy::withCount('applications')
                        ->whereNot('status', 'Open')
                        ->whereIn('type', ['Internal'])
                        ->get(),
                ]
            );
        } else {
            return view(
                'Result',
                [
                    'vacancies' => Vacancy::withCount('applications')
                        ->whereNot('status', 'Open')
                        ->whereIn('type', ['External', 'Experience', 'Assistant Level'])
                        ->get(),
                ]
            );
        }
    }
}
