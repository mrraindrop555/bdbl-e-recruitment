<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class AdminVacancyController extends Controller
{
    public function index()
    {
        return view('admin/adminindex', [
            'vacancies' => Vacancy::with('attachment')
                ->get()
        ]);
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
