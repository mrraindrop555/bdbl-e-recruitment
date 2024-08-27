<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Attachment;
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
        if ($vacancy->status != 'Shortlisted') {
            abort(403);
        }

        return view('shortlisted', [
            'vacancy' => $vacancy,
            'applications' => $vacancy->applications()
                ->where('is_shortlisted', true)
                ->get()
        ]);
    }

    public function showResubmissionForm(Request $request, Application $application)
    {   
        if ($application->resubmission_token != $request->query('token') || $application->resubmission_expires_at < now() || $application->vacancy->status != 'Open') {
            abort(403);
        }

        $application->load(['applicationFiles']);

        return view('admin.adminApplication', [
            'application' => $application,
            'is_resubmission' => true
        ]);
    }
}
