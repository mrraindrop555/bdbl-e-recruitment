<?php

namespace App\Livewire;

use Livewire\Component;

class MultiInput extends Component
{
    public $name;
    public $title;
    public $inputs = [null];

    public function mount()
    {
        $inputs = old($this->name);
        if ($inputs) {
            $this->inputs = $inputs;
        }
    }

    public function add()
    {
        array_push($this->inputs, null);
    }

    public function remove($index)
    {
        array_splice($this->inputs, $index, 1);
    }

    public function render()
    {
        return view('livewire.multi-input');
    }
}
