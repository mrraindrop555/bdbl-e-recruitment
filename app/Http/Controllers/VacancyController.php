<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        return view('Index', [
            'vacancies' => Vacancy::with('attachment')
                ->where('is_open', true)
                ->get()
        ]);
    }

    public function show(Request $request, Vacancy $vacancy)
    {
        return view(
            'Detail',
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
                'vacancies' => Vacancy::where('is_open', false)
                    ->get()
            ]
        );
    }
}
