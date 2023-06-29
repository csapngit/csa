<?php

namespace App\Exports\Tds;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromArray, WithHeadings, WithCustomCsvSettings
{
	private $arrayRemark;

	public function __construct($arrayRemark = [])
	{
		$this->arrayRemark = $arrayRemark;
	}

	public function getCsvSettings(): array
	{
		return [
			'delimiter' => ';',
			'enclosure' => false,
		];
	}

	public function headings(): array
	{
		return [
			'DistributorCode',
			'OrderNo',
			'SalesRepCode',
			'PONumber', // false
			'Remarks', // false
			'RetailerCode',
			'GoldenStoreStatus' //false
		];
	}

	public function array(): array
	{
		return $this->arrayRemark;
	}
}
