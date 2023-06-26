<?php

namespace App\Http\Livewire;

use App\Models\Key;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StatusApprove extends Component
{
  public $keys;

  public $keyId = '';

  public $approve_um;

  public $approve_rm;

  public $message;

  public function mount()
  {
    $this->keys = Key::where('status_um', '<>', true)
    ->orWhere('status_rm', '<>', true)
    ->get();

    // dd($this->keys);
  }

  public function selectedKey($value)
  {
    $this->keyId = $value;

    $key = Key::where('id', $this->keyId)->first();

    $this->approve_um = $key?->status_um;

    $this->approve_rm = $key?->status_rm;

    $this->formatStatus();
  }

  public function formatStatus()
  {
    if ($this->approve_um) {
      $this->approve_um = 'OK';
    } else {
      $this->approve_um = '-';
    }

    if ($this->approve_rm) {
      $this->approve_rm = 'OK';
    } else {
      $this->approve_rm = '-';
    }
  }

  public function render()
  {
    return view('livewire.status-approve');
  }
}
