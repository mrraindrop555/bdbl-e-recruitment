<?php

namespace App\Livewire;

use Livewire\Component;

class MarkInput extends Component
{
    public $name;
    public $subjects = ['ENG', 'DZO', 'MATH'];
    public $marks = [];
    public $best = 4;
    public $average = null;
    public $disabled = false;

    public function mount()
    {
        if($this->marks){
            return;
        }

        $marks = old($this->name);
        foreach ($this->subjects as $subject) {
            if ($marks) {
                $this->marks[$subject] = ['mark' => $marks[$subject]['mark'], 'highlight' => $marks[$subject]['highlight']];
            } else {
                $this->marks[$subject] = ['mark' => false, 'highlight' => false];
            }
        }

        if($marks){
            $this->change();
        }
    }

    public function change()
    {
        $first = $this->subjects[0];
        if ($this->marks[$first]['mark']) {
            $this->marks[$first]['highlight'] = true;
        } else {
            $this->marks[$first]['highlight'] = false;
        }

        uasort($this->marks, function ($a, $b) {
            return $b['mark'] <=> $a['mark']; // Descending order
        });

        $counter = $this->best;
        foreach ($this->marks as $key => $value) {
            if ($key != $this->subjects[0]) {
                if ($counter > 0 && $value['mark']) {
                    $this->marks[$key]['highlight'] = true;
                    $counter--;
                } else {
                    $this->marks[$key]['highlight'] = false;
                }
            }
        }

        //average
        $oldAvg = $this->average;
        if ($this->marks[$first]['mark'] && $counter == 0) {
            $average = 0;
            foreach ($this->marks as $value) {
                if ($value['highlight']) {
                    $average += $value['mark'];
                }
            }

            $this->average = round($average / ($this->best + 1), 2);
        } else {
            $this->average = null;
        }
        if ($this->average != $oldAvg) {
            $this->dispatch("average-changed", name: $this->name, average: $this->average, marks: $this->marks);
        }
    }

    public function render()
    {
        return view('livewire.mark-input');
    }
}
