<?php

namespace App\Exports\Tds;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderDetailExport implements FromArray, WithHeadings, WithCustomCsvSettings
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
		$token = env('TOKEN_TDS');

		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => request()->date,
		]);

		if ($response->json('data') == []) {
			return [];
		};

		$orders = $response->json('data');

		$detailData = [];

		foreach ($orders['data'] as $order) {
			foreach ($order['Detail'] as $detail) {
				$detailData[] = [
					'DistributorCode' => $order['DistributorCode'],
					'BranchCode' => $order['BranchCode'],
					'SalesRepCode' => $order['SalesRepCode'],
					'RetailerCode' => $order['RetailerCode'],
					'OrderNo' => $order['OrderNo'],
					'OrderDate' => date('m/d/Y', strtotime($order['OrderDate'])),
					'UploadDate' => null,
					'ChildSKUCode' => $detail['ChildSKUCode'],
					'OrderQty' => $detail['OrderQtyPcs'],
					'OrderQty(cases)' => 0,
					'DeliveryDate' => null,
					'D1' => null,
					'D2' => null,
					'D3' => null,
					'NonIM' => null,
					'DiscountAmount' => null,
					'DiscountRate' => null,
					'DiscountedPrice' => null,
					'GoldenStoreStatus' => null,
				];
			}
		}

		return $detailData;
	}
}
