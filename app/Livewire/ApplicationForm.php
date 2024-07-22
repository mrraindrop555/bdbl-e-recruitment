<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\ApplicationFile;
use App\Models\Attachment;
use App\Models\User;
use App\Notifications\VacancyApplied;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $vacancy;
    public $name;
    public $cid;
    public $email;
    public $class_x_school_name;
    public $class_x_completion_year;
    public $class_x_marksheet;
    public $class_x_marks;
    public $class_x_avg;
    public $class_xii_school_name;
    public $class_xii_stream = 'science';
    public $class_xii_completion_year;
    public $class_xii_marksheet;
    public $class_xii_marks;
    public $class_xii_avg;
    public $final_score;
    public $application;

    public function rules()
    {
        return [
            'name' => 'required',
            'cid' => ['required', 'integer', Rule::unique('applications', 'cid')->where(function ($query) {
                return $query->where('vacancy_id', $this->vacancy->id);
            })],
            'email' => 'required|email',
            'class_x_school_name' => 'required',
            'class_x_completion_year' => 'required',
            'class_x_marksheet' => 'required|file|max:5120',
            'class_x_marks' => 'required',
            'class_x_avg' => 'required|decimal:0,2',
            'class_xii_school_name' => 'required',
            'class_xii_completion_year' => 'required',
            'class_xii_marksheet' => 'required|file|max:5120',
            'class_xii_marks' => 'required',
            'class_xii_avg' => 'required|decimal:0,2',
            'final_score' => 'required|decimal:0,2',
        ];
    }

    public function mount()
    {
        if ($this->application) {
            $this->name = $this->application->name;
            $this->cid = $this->application->cid;
            $this->email = $this->application->email;
            $this->class_x_school_name = $this->application->class_x_school_name;
            $this->class_x_completion_year = $this->application->class_x_completion_year;
            $this->class_x_marksheet = $this->application->class_x_marksheet;
            $this->class_x_marks = $this->application->class_x_marks;
            $this->class_x_avg = $this->application->class_x_avg;
            $this->class_xii_school_name = $this->application->class_xii_school_name;
            $this->class_xii_stream = $this->application->class_xii_stream;
            $this->class_xii_completion_year = $this->application->class_xii_completion_year;
            $this->class_xii_marksheet = $this->application->class_xii_marksheet;
            $this->class_xii_marks = $this->application->class_xii_marks;
            $this->class_xii_avg = $this->application->class_xii_avg;
            $this->final_score = $this->application->final_score;
        }
    }

    public function apply()
    {
        Gate::allowIf(fn () => $this->vacancy->status == 'Open');

        $this->validate();

        DB::transaction(function () {
            $application = new Application([...collect($this->all())->except(['class_x_marksheet', 'class_xii_marksheet', 'vacancy', 'application']), 'is_shortlisted' => false]);
            $this->vacancy->applications()->save($application);

            $path = $this->class_x_marksheet->store('applicationFiles', 'public');
            $application->classXMarksheet()->save(new ApplicationFile(['filename' => $path]));

            $path = $this->class_x_marksheet->store('applicationFiles', 'public');
            $application->classXIIMarksheet()->save(new ApplicationFile(['filename' => $path]));

            Notification::send(User::all(), new VacancyApplied($application));
        });

        return redirect('/vacancy')->with('success', 'Applied successfully!');
    }

    public function render()
    {
        return view('livewire.application-form');
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

        if ($this->class_x_avg && $this->class_xii_avg) {
            $this->final_score = round(($this->class_x_avg + $this->class_xii_avg) / 2, 2);
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
