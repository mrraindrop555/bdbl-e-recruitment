<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use App\Notifications\ApplicationRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminApplicationController extends Controller
{
    public function index(Vacancy $vacancy)
    {
        $sort = request()->query('sort');

        if ($sort == "date_dsc") {
            return view('admin/adminshortlisted', [
                'vacancy' => $vacancy,
                'applications' => $vacancy->applications()
                    ->latest()
                    // ->orderBy('final_score', 'desc')
                    ->get()
            ]);
        } else if ($sort == "marks_asc") {
            return view('admin/adminshortlisted', [
                'vacancy' => $vacancy,
                'applications' => $vacancy->applications()
                    ->orderBy('final_score', 'asc')
                    ->get()
            ]);
        } else if ($sort == "marks_dsc") {
            return view('admin/adminshortlisted', [
                'vacancy' => $vacancy,
                'applications' => $vacancy->applications()
                    ->orderBy('final_score', 'desc')
                    ->get()
            ]);
        } else {
            return view('admin/adminshortlisted', [
                'vacancy' => $vacancy,
                'applications' => $vacancy->applications()
                    ->oldest()
                    ->get()
            ]);
        }
    }

    public function show(Application $application)
    {
        $application->load(['applicationFiles']);

        return view('admin.adminApplication', [
            'application' => $application,
            'is_resubmission' => false
        ]);
    }


}
