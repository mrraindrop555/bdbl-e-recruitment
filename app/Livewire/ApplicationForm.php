<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\ApplicationFile;
use App\Models\User;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\ApplicationRejected;
use App\Notifications\ApplicationResubmitted;
use App\Notifications\VacancyApplied;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $vacancy;
    public $is_resubmission;
    public $name;
    public $cid;
    public $email;
    #[Validate]
    public $passport_photo;
    public $citizenship_identity_card;
    public $security_clearance_certificate;
    public $medical_certificate;
    public $cv;
    public $noc;
    public $present_position;
    public $present_division;
    public $number_of_years_served;
    public $reason;
    public $supervisor_recommendation_letter;
    public $class_x_school_name;
    public $class_x_completion_year;
    public $class_x_marksheet;
    public $class_x_marks = [];
    public $class_x_avg;
    public $class_xii_school_name;
    public $class_xii_stream = 'science';
    public $class_xii_completion_year;
    public $class_xii_marksheet;
    public $class_xii_marks = [];
    public $class_xii_avg;
    public $university_or_college_name;
    public $university_or_college_course_name;
    public $university_or_college_completion_year;
    public $university_or_college_percentage;
    public $university_or_college_marksheet;
    public $degree_completed = false;
    public $masters_institution_name;
    public $masters_course_name;
    public $masters_completion_year;
    public $masters_percentage;
    public $masters_marksheet;
    public $final_score;
    public $application;
    public $rejection_remarks;

    public $current_page = 1;
    public $last_page = 0;
    public $state = 'view';

    #[Url]
    public ?string $token;

    public function rules()
    {
        $vs = [
            "personal_details" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'passport_photo' => 'image|max:1024|required',
                'citizenship_identity_card' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'security_clearance_certificate' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'medical_certificate' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'cv' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
            ],
            "personal_details_experience" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'passport_photo' => 'image|max:1024|required',
                'citizenship_identity_card' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'security_clearance_certificate' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'medical_certificate' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'cv' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'noc' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
            ],
            "personal_details_internal" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'present_position' => 'required',
                'present_division' => 'required',
                'number_of_years_served' => 'required|numeric',
                'reason' => 'required',
                'supervisor_recommendation_letter' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
            ],
            "class_x" => [
                'class_x_school_name' => 'required',
                'class_x_completion_year' => 'required',
                'class_x_marksheet' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'class_x_marks' => 'required',
                'class_x_avg' => 'required|decimal:0,2|min:0|max:100',
            ],
            "class_xii" => [
                'class_xii_school_name' => 'required',
                'class_xii_completion_year' => 'required',
                'class_xii_marksheet' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'class_xii_marks' => 'required',
                'class_xii_avg' => 'required|decimal:0,2|min:0|max:100',
            ],
            "degree" => [
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
            "degree_assistant_level" => [
                'degree_completed' => 'required|boolean',
                'university_or_college_name' => 'required_if:degree_completed,true',
                'university_or_college_course_name' => 'required_if:degree_completed,true',
                'university_or_college_completion_year' => 'required_if:degree_completed,true',
                'university_or_college_percentage' => 'required_if:degree_completed,true',
                'university_or_college_marksheet' => 'required_if:degree_completed,true|nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
            "degree_experience" => [
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
            ],
            "masters" => [
                'masters_institution_name' => 'required',
                'masters_course_name' => 'required',
                'masters_completion_year' => 'required',
                'masters_percentage' => 'required',
                'masters_marksheet' => 'required|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ]
        ];

        $evs = [
            "external_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications')->ignore($this->application?->cid, 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'class_x_school_name' => 'required',
                'class_x_completion_year' => 'required',
                'class_x_marks' => 'required',
                'class_x_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'class_x_avg' => 'required|decimal:0,2|min:0|max:100',
                'class_xii_school_name' => 'required',
                'class_xii_completion_year' => 'required',
                'class_xii_marks' => 'required',
                'class_xii_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'class_xii_avg' => 'required|decimal:0,2|min:0|max:100',
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
                'passport_photo' => 'nullable|image|max:1024',
                'citizenship_identity_card' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'security_clearance_certificate' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'medical_certificate' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'cv' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
            ],
            "internal_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications')->ignore($this->application?->cid, 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'present_position' => 'required',
                'present_division' => 'required',
                'number_of_years_served' => 'required|numeric',
                'reason' => 'required',
            ],
            "experience_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications')->ignore($this->application?->cid, 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'masters_institution_name' => 'required',
                'masters_course_name' => 'required',
                'masters_completion_year' => 'required',
                'masters_percentage' => 'required',
                'masters_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
            "assistant_level_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications')->ignore($this->application?->cid, 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'class_x_school_name' => 'required',
                'class_x_completion_year' => 'required',
                'class_x_marks' => 'required',
                'class_x_avg' => 'required|decimal:0,2|min:0|max:100',
                'class_xii_school_name' => 'required',
                'class_xii_completion_year' => 'required',
                'class_xii_marks' => 'required',
                'class_xii_avg' => 'required|decimal:0,2|min:0|max:100',
                'degree_completed' => 'required|boolean',
                'university_or_college_name' => 'required_if:degree_completed,true',
                'university_or_college_course_name' => 'required_if:degree_completed,true',
                'university_or_college_completion_year' => 'required_if:degree_completed,true',
                'university_or_college_percentage' => 'required_if:degree_completed,true',
                'university_or_college_marksheet' => 'nullable|mimes:pdf,jpeg,png,jpg|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
        ];

        if ($this->state == 'editing' || $this->is_resubmission) {
            if ($this->vacancy->type == 'External') {
                return $evs['external_edit'];
            } elseif ($this->vacancy->type == 'Experience') {
                return $evs['experience_edit'];
            } elseif ($this->vacancy->type == 'Internal') {
                return $evs['internal_edit'];
            } elseif ($this->vacancy->type == 'Assistant Level') {
                return $evs['assistant_level_edit'];
            }
        } else {
            $page_validations = [];
            if ($this->vacancy->type == 'External') {
                $page_validations = [$vs['personal_details'], $vs['class_x'], $vs['class_xii'], $vs['degree']];
            } elseif ($this->vacancy->type == 'Experience') {
                $page_validations = [$vs['personal_details_experience'], $vs['degree_experience'], $vs['masters']];
            } elseif ($this->vacancy->type == 'Internal') {
                $page_validations = [$vs['personal_details_internal'], $vs['class_x'], $vs['class_xii'], $vs['degree_assistant_level']];
            } elseif ($this->vacancy->type == 'Assistant Level') {
                $page_validations = [$vs['personal_details'], $vs['class_x'], $vs['class_xii'], $vs['degree_assistant_level']];
            }

            if ($this->current_page != $this->last_page) {
                return $page_validations[$this->current_page - 1];
            } else {
                $final_validations = [];
                foreach ($page_validations as $validation) {
                    $final_validations = array_merge($final_validations, $validation);
                }
                return $final_validations;
            }
        }
    }

    public function mount()
    {
        if ($this->application) {
            $this->setValues();
        }

        if ($this->vacancy->type == 'Internal') {
            $this->last_page = 4;
        } else if ($this->vacancy->type == 'External') {
            $this->last_page = 4;
        } else if ($this->vacancy->type == 'Experience') {
            $this->last_page = 3;
        } else if ($this->vacancy->type == 'Assistant Level') {
            $this->last_page = 4;
        }
    }

    public function setValues()
    {
        $this->name = $this->application->name;
        $this->cid = $this->application->cid;
        $this->email = $this->application->email;
        $this->present_position = $this->application->present_position;
        $this->present_division = $this->application->present_division;
        $this->number_of_years_served = $this->application->number_of_years_served;
        $this->reason = $this->application->reason;
        $this->class_x_school_name = $this->application->class_x_school_name;
        $this->class_x_completion_year = $this->application->class_x_completion_year;
        $this->class_x_marks = $this->application->class_x_marks;
        $this->class_x_avg = $this->application->class_x_avg;
        $this->class_xii_school_name = $this->application->class_xii_school_name;
        $this->class_xii_stream = $this->application->class_xii_stream;
        $this->class_xii_completion_year = $this->application->class_xii_completion_year;
        $this->class_xii_marks = $this->application->class_xii_marks;
        $this->class_xii_avg = $this->application->class_xii_avg;
        $this->university_or_college_name = $this->application->university_or_college_name;
        $this->university_or_college_course_name = $this->application->university_or_college_course_name;
        $this->university_or_college_completion_year = $this->application->university_or_college_completion_year;
        $this->university_or_college_percentage = $this->application->university_or_college_percentage;
        $this->degree_completed = $this->application->degree_completed;
        $this->masters_institution_name = $this->application->masters_institution_name;
        $this->masters_course_name = $this->application->masters_course_name;
        $this->masters_completion_year = $this->application->masters_completion_year;
        $this->masters_percentage = $this->application->masters_percentage;

        $this->final_score = $this->application->final_score;
    }

    public function apply()
    {
        if ($this->vacancy->status != 'Open') {
            abort(403);
        }

        $this->validate();

        DB::transaction(function () {
            $application = new Application([...collect($this->all())->except([
                'passport_photo',
                'citizenship_identity_card',
                'security_clearance_certificate',
                'medical_certificate',
                'cv',
                'noc',
                'supervisor_recommendation_letter',
                'class_x_marksheet',
                'class_xii_marksheet',
                'university_or_college_marksheet',
                'masters_marksheet',
                'vacancy',
                'is_resubmission',
                'application',
                'current_page',
                'last_page',
                'state',
                'token'
            ]), 'is_shortlisted' => false]);
            $this->vacancy->applications()->save($application);

            $this->save_files($application);

            $application->notify(new ApplicationSubmitted($application));
            Notification::send(User::all(), new VacancyApplied($application));
        });

        if ($this->vacancy->type == 'Internal') {
            return redirect('/vacancy?type=internal')->with('success', 'Applied successfully! Please check your inbox/spam for confirmation.');
        } else {
            return redirect('/vacancy')->with('success', 'Applied successfully! Please check your inbox/spam for confirmation.');
        }
    }

    public function edit()
    {
        if ($this->is_resubmission) {
            if ($this->application->resubmission_token != $this->token || $this->application->resubmission_expires_at < now() || $this->application->vacancy->status != 'Open') {
                abort(403);
            }
        }

        $this->validate();

        DB::transaction(function () {
            if ($this->vacancy->type == 'External') {
                $this->application->update([
                    'name' => $this->name,
                    'cid' => $this->cid,
                    'email' => $this->email,
                    'class_x_school_name' => $this->class_x_school_name,
                    'class_x_completion_year' => $this->class_x_completion_year,
                    'class_x_marks' => $this->class_x_marks,
                    'class_x_avg' => $this->class_x_avg,
                    'class_xii_school_name' => $this->class_xii_school_name,
                    'class_xii_completion_year' => $this->class_xii_completion_year,
                    'class_xii_marks' => $this->class_xii_marks,
                    'class_xii_avg' => $this->class_xii_avg,
                    'university_or_college_name' => $this->university_or_college_name,
                    'university_or_college_course_name' => $this->university_or_college_course_name,
                    'university_or_college_completion_year' => $this->university_or_college_completion_year,
                    'university_or_college_percentage' => $this->university_or_college_percentage,
                    'final_score' => $this->final_score,
                ]);
            } else if ($this->vacancy->type == 'Internal') {
                $this->application->update([
                    'name' => $this->name,
                    'cid' => $this->cid,
                    'email' => $this->email,
                    'present_position' => $this->present_position,
                    'present_division' => $this->present_division,
                    'number_of_years_served' => $this->number_of_years_served,
                    'reason' => $this->reason,
                    'class_x_school_name' => $this->class_x_school_name,
                    'class_x_completion_year' => $this->class_x_completion_year,
                    'class_x_marks' => $this->class_x_marks,
                    'class_x_avg' => $this->class_x_avg,
                    'class_xii_school_name' => $this->class_xii_school_name,
                    'class_xii_completion_year' => $this->class_xii_completion_year,
                    'class_xii_marks' => $this->class_xii_marks,
                    'class_xii_avg' => $this->class_xii_avg,
                    'degree_completed' => $this->degree_completed,
                    'university_or_college_name' => $this->university_or_college_name,
                    'university_or_college_course_name' => $this->university_or_college_course_name,
                    'university_or_college_completion_year' => $this->university_or_college_completion_year,
                    'university_or_college_percentage' => $this->university_or_college_percentage,
                    'final_score' => $this->final_score,
                ]);
            } else if ($this->vacancy->type == 'Experience') {
                $this->application->update([
                    'name' => $this->name,
                    'cid' => $this->cid,
                    'email' => $this->email,
                    'university_or_college_name' => $this->university_or_college_name,
                    'university_or_college_course_name' => $this->university_or_college_course_name,
                    'university_or_college_completion_year' => $this->university_or_college_completion_year,
                    'university_or_college_percentage' => $this->university_or_college_percentage,
                    'masters_institution_name' => $this->masters_institution_name,
                    'masters_course_name' => $this->masters_course_name,
                    'masters_completion_year' => $this->masters_completion_year,
                    'masters_percentage' => $this->masters_percentage,
                    'final_score' => $this->final_score,
                ]);
            } else if ($this->vacancy->type == 'Assistant Level') {
                $this->application->update([
                    'name' => $this->name,
                    'cid' => $this->cid,
                    'email' => $this->email,
                    'class_x_school_name' => $this->class_x_school_name,
                    'class_x_completion_year' => $this->class_x_completion_year,
                    'class_x_marks' => $this->class_x_marks,
                    'class_x_avg' => $this->class_x_avg,
                    'class_xii_school_name' => $this->class_xii_school_name,
                    'class_xii_completion_year' => $this->class_xii_completion_year,
                    'class_xii_marks' => $this->class_xii_marks,
                    'class_xii_avg' => $this->class_xii_avg,
                    'degree_completed' => $this->degree_completed,
                    'university_or_college_name' => $this->university_or_college_name,
                    'university_or_college_course_name' => $this->university_or_college_course_name,
                    'university_or_college_completion_year' => $this->university_or_college_completion_year,
                    'university_or_college_percentage' => $this->university_or_college_percentage,
                    'final_score' => $this->final_score,
                ]);
            }

            if ($this->is_resubmission) {
                $this->save_files($this->application);

                $this->application->update([
                    'rejection_remarks' => null,
                    'resubmission_token' => null,
                    'resubmission_expires_at' => null,
                ]);

                Notification::send(User::all(), new ApplicationResubmitted($this->application));
            }
        });

        if ($this->is_resubmission) {
            if ($this->vacancy->type = 'Internal') {
                return redirect('/vacancy?type=internal')->with('success', 'Application resubmitted successfully!');
            } else {
                return redirect('/vacancy')->with('success', 'Application resubmitted successfully!');
            }
        } else {
            return redirect("/admin/result/{$this->vacancy->id}")->with('success', 'Application edited successfully!');
        }
    }

    public function reject()
    {
        if (!auth() || $this->vacancy->status != 'Open') {
            abort(403);
        }

        $this->validate(["rejection_remarks" => 'required']);

        $this->application->update([
            'rejection_remarks' => $this->rejection_remarks,
            'resubmission_token' => Str::random(60),
            'resubmission_expires_at' => now()->addDays(7), // Set expiration to 7 days from now
        ]);

        // Send email to the applicant
        $application = Application::find($this->application->id);
        $application->notify(new ApplicationRejected($application));
        // Mail::to($application->applicant_email)->send(new ApplicationRejected($application));

        return redirect("/admin/result/{$this->vacancy->id}")->with('success', 'Application Rejected');
    }

    public function save_files(Application $application)
    {
        if ($this->passport_photo) {
            $path = $this->passport_photo->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'passport_photo')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'passport_photo']));
        }
        if ($this->citizenship_identity_card) {
            $path = $this->citizenship_identity_card->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'citizenship_identity_card')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'citizenship_identity_card']));
        }
        if ($this->medical_certificate) {
            $path = $this->medical_certificate->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'medical_certificate')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'medical_certificate']));
        }
        if ($this->cv) {
            $path = $this->cv->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'cv')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'cv']));
        }
        if ($this->supervisor_recommendation_letter) {
            $path = $this->supervisor_recommendation_letter->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'supervisor_recommendation_letter')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'supervisor_recommendation_letter']));
        }
        if ($this->noc) {
            $path = $this->noc->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'noc')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'noc']));
        }
        if ($this->class_x_marksheet) {
            $path = $this->class_x_marksheet->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'class_x_marksheet')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'class_x_marksheet']));
        }
        if ($this->class_xii_marksheet) {
            $path = $this->class_xii_marksheet->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'class_xii_marksheet')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'class_xii_marksheet']));
        }
        if ($this->university_or_college_marksheet) {
            $path = $this->university_or_college_marksheet->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'university_or_college_marksheet')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'university_or_college_marksheet']));
        }
        if ($this->masters_marksheet) {
            $path = $this->masters_marksheet->store('applicationFiles', 'public');
            $application->applicationFiles->where('type', 'masters_marksheet')->first()?->delete();
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'masters_marksheet']));
        }
    }

    public function next()
    {
        $this->validate();

        $this->current_page++;
    }

    public function back()
    {
        $this->current_page--;
    }

    public function render()
    {
        return view('livewire.application-form');
    }

    public function onEditButtonPressed()
    {
        $this->state = 'editing';
    }

    public function onEditCancelButtonPressed()
    {
        $this->state = 'view';

        $this->setValues();
    }

    public function onPercentageChanged()
    {
        if ($this->vacancy->type == 'External') {
            if ($this->class_x_avg && $this->class_xii_avg && $this->university_or_college_percentage) {
                $this->final_score = round(($this->class_x_avg * 30 + $this->class_xii_avg * 30 + $this->university_or_college_percentage * 40) / 100, 2);
            } else {
                $this->final_score = null;
            }
        } else if ($this->vacancy->type == 'Assistant Level' || $this->vacancy->type == 'Internal') {
            if ($this->degree_completed) {
                if ($this->class_x_avg && $this->class_xii_avg && $this->university_or_college_percentage) {
                    $this->final_score = round(($this->class_x_avg * 30 + $this->class_xii_avg * 30 + $this->university_or_college_percentage * 40) / 100, 2);
                } else {
                    $this->final_score = null;
                }
            } else {
                if ($this->class_x_avg && $this->class_xii_avg) {
                    $this->final_score = round(($this->class_x_avg * 50 + $this->class_xii_avg * 50) / 100, 2);
                } else {
                    $this->final_score = null;
                }
            }
        } else {
            if ($this->university_or_college_percentage && $this->masters_percentage) {
                $this->final_score = round(($this->university_or_college_percentage + $this->masters_percentage) / 2, 2);
            } else {
                $this->final_score = null;
            }
        }
    }


    #[On('average-changed')]
    public function onAverageChanged($name, $average, $marks)
    {
        if ($name == 'classX') {
            $this->class_x_avg = $average;
            $this->class_x_marks = $marks;
        } elseif ($name == 'classXII') {
            $this->class_xii_avg = $average;
            $this->class_xii_marks = $marks;
        }

        $this->onPercentageChanged();
    }

    #[On('stream-changed')]
    public function onStreamChanged($stream)
    {
        $this->final_score = null;
        $this->class_xii_stream = $stream;
    }
}
