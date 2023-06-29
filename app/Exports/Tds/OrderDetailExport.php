<?php

namespace App\Exports\Tds;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderDetailExport implements FromArray, WithHeadings, WithCustomCsvSettings
{
	private $hilih;

	public function __construct($hilih = [])
	{
		$this->hilih = $hilih;
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
			'BranchCode',
			'SalesRepCode',
			'RetailerCode',
			'OrderNo',
			'OrderDate',
			'UploadDate',
			'ChildSKUCode',
			'OrderQty',
			'OrderQty(cases)',
			'DeliveryDate',
			'D1',
			'D2',
			'D3',
			'NonIM',
			'DiscountAmount',
			'DiscountRate',
			'DiscountedPrice',
			'GoldenStoreStatus',
		];
	}

	public function array(): array
	{
		return $this->hilih;
	}
}
