<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;

class AdminApplicationController extends Controller
{
    public function index(Vacancy $vacancy)
    {
        return view('admin/adminshortlisted', [
            'vacancy' => $vacancy,
            'applications' => $vacancy->applications()
                ->orderBy('final_score', 'desc')
                ->get()
        ]);
    }

    public function show(Application $application)
    {
        $application->load(['vacancy']);

        return view('admin.adminApplication', [
            'application' => $application
        ]);
    }
}
