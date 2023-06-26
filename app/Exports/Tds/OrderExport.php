<?php

namespace App\Exports\Tds;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromArray, WithHeadings, WithCustomCsvSettings
{
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
		$token = env('TOKEN_TDS');

		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => request()->date,
		]);

		// dd($response->json());

		if ($response->json('data') == []) {
			return [];
		};

		$orders = $response->json('data');

		// dd($orders['data']);

		$header = [];

		foreach ($orders['data'] as $order) {
			$header[] = [
				'DistributorCode' => $order['DistributorCode'],
				'OrderNo' => $order['OrderNo'],
				'SalesRepCode' => $order['SalesRepCode'],
				'PONumber' => null,
				'Remarks' => null,
				'RetailerCode' => $order['RetailerCode'],
				'GoldenStoreStatus' => null
			];
		}

		// dd($header);

		return $header;
	}
}
