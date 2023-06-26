<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HeaderSheetImageExport implements WithMultipleSheets
{
	public function sheets(): array
	{
		$sheets = [];

		// dd(request()->all());

		$storeChild = DB::table('store_categories')
			->join('master_stores', 'store_categories.id', 'master_stores.store_id')
			->where('master_stores.store_id', request()->store_id)
			// ->get();
			->count();

		// dd($storeChild);

		for ($i = 1; $i <= $storeChild; $i++) {
			$sheets[] = new ProgramImageExport($i);
		}

		return $sheets;
	}
}
