<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait GetOrderTrait
{
	public function orderRemark($branchCode)
	{
		$token = env('TOKEN_TDS');

		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => request()->date,
			'startTime' => '13:00:00',
			'endTime' => '17:00:00',
		]);

		if ($response['data']['data'] == []) {
			return [];
		};

		$orders = collect($response['data']['data'])->where('BranchCode', $branchCode)->toArray();

		$header = [];

		foreach ($orders as $order) {
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

		return $header;
	}

	public function orderDetail($branchCode)
	{
		$token = env('TOKEN_TDS');

		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => request()->date,
			'startTime' => '13:00:00',
			'endTime' => '17:00:00',
		]);

		if ($response['data']['data'] == []) {
			return [];
		};

		$orders = collect($response['data']['data'])->where('BranchCode', $branchCode)->toArray();

		// dd($orders);

		$detailData = [];

		foreach ($orders as $data) {
			foreach ($data['Detail'] as $detail) {
				$detailData[$branchCode][] = [
					'DistributorCode' => $data['DistributorCode'],
					'BranchCode' => $data['BranchCode'],
					'SalesRepCode' => $data['SalesRepCode'],
					'RetailerCode' => $data['RetailerCode'],
					'OrderNo' => $data['OrderNo'],
					'OrderDate' => date('m/d/Y', strtotime($data['OrderDate'])),
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
