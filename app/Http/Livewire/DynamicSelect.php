<?php

namespace App\Http\Livewire;

use App\Enums\AreaEnum;
use App\Models\Program;
use Livewire\Component;

class DynamicSelect extends Component
{
  public $areas;

  public $area;

  public $programs = [];

  public function mount()
  {
    $this->areas = AreaEnum::AREA;
  }

  public function selectedArea($area)
  {
    $this->area = $area;

    if ($this->area) {
      $this->programs = Program::where('area', $this->area)->get();
    }
  }

  public function render()
  {
    return view('livewire.dynamic-select');
  }
}
