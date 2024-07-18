<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class AdminApplicationController extends Controller
{
    public function index(Vacancy $vacancy)
    {
        return view('admin/adminshortlisted', [
            'vacancy' => $vacancy,
            'applications' => $vacancy->applications()
                ->orderBy('marks', 'desc')
                ->get()
        ]);
    }
}
