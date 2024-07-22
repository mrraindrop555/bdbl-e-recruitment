<?php

namespace App\Livewire;

use Livewire\Component;

class StreamInput extends Component
{
    public $stream = 'science';
    public $marks = [];
    public $average = null;
    public $disabled = false;

    public function change()
    {
        $this->dispatch('stream-changed', $this->stream);
    }

    public function render()
    {
        return view('livewire.stream-input');
    }
}
