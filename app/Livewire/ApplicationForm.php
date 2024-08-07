<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\ApplicationFile;
use App\Models\User;
use App\Notifications\VacancyApplied;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicationForm extends Component
{
    use WithFileUploads;

    #[Validate]
    public $vacancy;
    public $name;
    public $cid;
    public $email;
    public $passport_photo;
    public $citizenship_identity_card;
    public $security_clearance_certificate;
    public $medical_certificate;
    public $cv;
    public $noc;
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
    public $masters_institution_name;
    public $masters_course_name;
    public $masters_completion_year;
    public $masters_percentage;
    public $masters_marksheet;
    public $final_score;
    public $application;

    public $current_page = 1;
    public $last_page = 0;
    public $is_editing = false;

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
                'citizenship_identity_card' => 'required|mimes:pdf|max:1024',
                'security_clearance_certificate' => 'required|mimes:pdf|max:1024',
                'medical_certificate' => 'required|mimes:pdf|max:1024',
                'cv' => 'required|mimes:pdf|max:1024',
            ],
            "personal_details_experience" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'passport_photo' => 'image|max:1024|required',
                'citizenship_identity_card' => 'required|mimes:pdf|max:1024',
                'security_clearance_certificate' => 'required|mimes:pdf|max:1024',
                'medical_certificate' => 'required|mimes:pdf|max:1024',
                'cv' => 'required|mimes:pdf|max:1024',
                'noc' => 'nullable|mimes:pdf|max:1024',
            ],
            "personal_details_internal" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'cv' => 'required|mimes:pdf|max:1024',
            ],
            "class_x" => [
                'class_x_school_name' => 'required',
                'class_x_completion_year' => 'required',
                'class_x_marksheet' => 'required|mimes:pdf|max:1024',
                'class_x_marks' => 'required',
                'class_x_avg' => 'required|decimal:0,2|min:0|max:100',
            ],
            "class_xii" => [
                'class_xii_school_name' => 'required',
                'class_xii_completion_year' => 'required',
                'class_xii_marksheet' => 'required|mimes:pdf|max:1024',
                'class_xii_marks' => 'required',
                'class_xii_avg' => 'required|decimal:0,2|min:0|max:100',
            ],
            "degree" => [
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'required|mimes:pdf|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
            "degree_experience" => [
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'university_or_college_marksheet' => 'required|mimes:pdf|max:1024',
            ],
            "masters" => [
                'masters_institution_name' => 'required',
                'masters_course_name' => 'required',
                'masters_completion_year' => 'required',
                'masters_percentage' => 'required',
                'masters_marksheet' => 'required|mimes:pdf|max:1024',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ]
        ];

        $evs = [
            "external_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
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
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ],
            "internal_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
            ],
            "experience_edit" => [
                'name' => 'required',
                'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                    return $query->where('vacancy_id', $this->vacancy->id);
                })],
                'email' => 'required|email',
                'university_or_college_name' => 'required',
                'university_or_college_course_name' => 'required',
                'university_or_college_completion_year' => 'required',
                'university_or_college_percentage' => 'required',
                'masters_institution_name' => 'required',
                'masters_course_name' => 'required',
                'masters_completion_year' => 'required',
                'masters_percentage' => 'required',
                'final_score' => 'required|decimal:0,2|min:0|max:100',
            ]
        ];

        if (!$this->is_editing) {
            $page_validations = [];
            if ($this->vacancy->type == 'External') {
                $page_validations = [$vs['personal_details'], $vs['class_x'], $vs['class_xii'], $vs['degree']];
            } elseif ($this->vacancy->type == 'Experience') {
                $page_validations = [$vs['personal_details_experience'], $vs['degree_experience'], $vs['masters']];
            } elseif ($this->vacancy->type == 'Internal') {
                $page_validations = [$vs['personal_details_internal']];
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
        } else {
            if ($this->vacancy->type == 'External') {
                return $evs['external_edit'];
            } elseif ($this->vacancy->type == 'Experience') {
                return $evs['experience_edit'];
            } elseif ($this->vacancy->type == 'Internal') {
                return $evs['internal_edit'];
            }
        }
    }

    public function mount()
    {
        if ($this->application) {
            $this->setValues();
        }

        if ($this->vacancy->type == 'Internal') {
            $this->last_page = 1;
        } else if ($this->vacancy->type == 'External') {
            $this->last_page = 4;
        } else if ($this->vacancy->type == 'Experience') {
            $this->last_page = 3;
        }
    }

    public function setValues()
    {
        $this->name = $this->application->name;
        $this->cid = $this->application->cid;
        $this->email = $this->application->email;
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
                'passport_photo', 'citizenship_identity_card', 'security_clearance_certificate', 'medical_certificate', 'cv', 'noc',
                'class_x_marksheet', 'class_xii_marksheet', 'university_or_college_marksheet', 'masters_marksheet',
                'vacancy', 'application', 'current_page', 'last_page', 'is_editing'
            ]), 'is_shortlisted' => false]);
            $this->vacancy->applications()->save($application);

            if ($this->vacancy->type != 'Internal') {
                $path = $this->passport_photo->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'passport_photo']));

                $path = $this->citizenship_identity_card->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'citizenship_identity_card']));

                $path = $this->security_clearance_certificate->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'security_clearance_certificate']));

                $path = $this->medical_certificate->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'medical_certificate']));
            }

            $path = $this->cv->store('applicationFiles', 'public');
            $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'cv']));

            if ($this->vacancy->type == 'Experience' && $this->noc) {
                $path = $this->noc->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'noc']));
            }

            if ($this->vacancy->type == 'External') {
                $path = $this->class_x_marksheet->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'class_x_marksheet']));
            }

            if ($this->vacancy->type == 'External') {
                $path = $this->class_xii_marksheet->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'class_xii_marksheet']));
            }

            if ($this->vacancy->type != 'Internal') {
                $path = $this->university_or_college_marksheet->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'university_or_college_marksheet']));
            }

            if ($this->vacancy->type == 'Experience') {
                $path = $this->masters_marksheet->store('applicationFiles', 'public');
                $application->applicationFiles()->save(new ApplicationFile(['filename' => $path, 'type' => 'masters_marksheet']));
            }

            Notification::send(User::all(), new VacancyApplied($application));
        });

        return redirect('/vacancy')->with('success', 'Applied successfully!');
    }

    public function edit()
    {
        $this->validate();

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
        } else if ($this->vacancy->type == 'External') {
            $this->application->update([
                'name' => $this->name,
                'cid' => $this->cid,
                'email' => $this->email,
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
        }

        return redirect("/admin/result/{$this->vacancy->id}")->with('success', 'Application edited successfully!');
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
        $this->is_editing = true;
    }

    public function onEditCancelButtonPressed()
    {
        $this->is_editing = false;

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

        if ($this->class_x_avg && $this->class_xii_avg && $this->university_or_college_percentage) {
            $this->final_score = round(($this->class_x_avg * 30 + $this->class_xii_avg * 30 + $this->university_or_college_percentage * 40) / 100, 2);
        } else {
            $this->final_score = null;
        }
    }

    #[On('stream-changed')]
    public function onStreamChanged($stream)
    {
        $this->final_score = null;
        $this->class_xii_stream = $stream;
    }
}
