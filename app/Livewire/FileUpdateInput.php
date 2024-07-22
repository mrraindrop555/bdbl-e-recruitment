<?php

namespace App\Livewire;

use Livewire\Component;

class FileUpdateInput extends Component
{
    public $name;
    public $file;
    public $delete = false;

    public function mount()
    {
        if ($this->file) {
            $this->delete = false;
        } else {
            $this->delete = true;
        }
    }

    public function deleteFile()
    {
        $this->delete = true;
    }

    public function render()
    {
        return view('livewire.file-update-input');
    }
}
