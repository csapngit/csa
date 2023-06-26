<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StatusWidgetApprove extends Component
{
	public $voucherCount;

	protected $listeners = ['getTotalVoucher' => 'totalVoucher'];

	public function totalVoucher($generates)
	{
		$this->voucherCount = collect($generates)->count();

		// dd(collect($generates)->count());
	}

	public function render()
	{
		return view('livewire.status-widget-approve');
	}
}
