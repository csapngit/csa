<?php

namespace App\Imports;

use App\Traits\SapAuthTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClaimCustomersImport implements ToCollection, WithHeadingRow
{
	use SapAuthTrait;

	/**
	 * @param Collection $collection
	 */
	public function collection(Collection $collection)
	{
		$excelData = collect($collection->toArray());

		$data = [];

		foreach ($excelData as $row) {
			$data['SOL_RBT_D1Collection'][] = [
				'U_SOL_CODE_CUST' => $row['customer_code'],
				'U_SOL_NM_CUST' => $row['customer_name'],
				'U_SOL_DISPLAY' => $row['display'],
				'U_SOL_FOTO' => $row['foto'],
				'U_SOL_KONTRAK' => $row['kontrak'],
			];
		}

		$sessionId = $this->login();

		$rebate_code = request()->rebate_code;

		$url = "$this->ipApi/b1s/v1/SOL_RBT('$rebate_code')";

		$headers = [
			'Cookie' => 'B1SESSION=' . $sessionId . ';',
		];

		$asdf = Http::withoutVerifying()
			->withHeaders($headers)
			->patch($url, $data)
			->json();

		if ($asdf['error'] ?? []) {
			return back()->with('warning', $asdf['error']['message']['value']);
		};

		$this->logout();

		return back()->with('success', __('message.data_uploaded'));
	}
}
