<?php

namespace App\Http\Livewire;

use App\Enums\AreaEnum;
use App\Enums\StatusKeyEnum;
use App\Models\Generate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
	use WithPagination;

	public $areas;

	public $selectedArea;

	public $generates = [];

	public function mount()
	{
		$this->areas = AreaEnum::AREA;
	}

	public function getdataTable()
	{
		$generates = DB::table('generates')
			->join('keys', 'generates.key_id', 'keys.id')
			->where('keys.status_active', StatusKeyEnum::OPEN)
			->where('keys.status_um', true)
			->where('keys.status_rm', true)
			->where('generates.area', $this->selectedArea)
			->select(
				'generates.customer_id',
				'generates.name',
				'generates.target',
				'generates.offtakes',
				'generates.can_publish',
			)
			->get();

		$this->generates = $generates;

		// emit to StatusWidgetApprove
		$this->emit('getTotalVoucher', $generates);
	}

	public function render()
	{
		return view('livewire.table');
	}
}
