<?php

namespace App\Livewire;

use Livewire\Component;

class AdminIndex extends Component
{
    public $sort = "Non Archived";
    public $vacancies;

    public function render()
    {
        return view('livewire.admin-index');
    }
}
