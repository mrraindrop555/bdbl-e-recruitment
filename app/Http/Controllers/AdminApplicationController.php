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
                ->oldest()
                // ->orderBy('final_score', 'desc')
                ->get()
        ]);
    }

    public function show(Application $application)
    {
        $application->load(['applicationFiles']);

        return view('admin.adminApplication', [
            'application' => $application
        ]);
    }
}
