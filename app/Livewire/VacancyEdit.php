<?php

namespace App\Livewire;

use Livewire\Component;

class VacancyEdit extends Component
{
    public $vacancy;
    public $closure;

    public function mount()
    {
        $this->closure = old('closure') ? old('closure') : $this->vacancy->closure;
    }

    public function render()
    {
        return view('livewire.vacancy-edit');
    }
}
