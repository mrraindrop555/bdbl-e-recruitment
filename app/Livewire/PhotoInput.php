<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoInput extends Component
{
    use WithFileUploads;

    public $title;
    public $name;
    public $ratio;

    #[Validate('image')]
    public $photo;

    public function change()
    {
        $this->dispatch("photo-changed", $this->photo);
        // dd($this->photo);
    }

    public function render()
    {
        return view('livewire.photo-input');
    }
}
