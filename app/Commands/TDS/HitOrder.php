<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HitOrder
{
	public function __invoke()
	{
		$date = Carbon::now()->format('Y-m-d');

		$token = env('TOKEN_TDS');

		$arrayDataOrder = [];

		//Hit API
		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => $date,
		]);

		$currentTime = Carbon::now()->format('H:i:s');

		$arrayDataOrder = $response['data']['data'];

		$dbDatas = [];

		$dateHour = Carbon::now()->format('Y-m-d H:i:s');

		foreach ($arrayDataOrder as $dataorder) {
			foreach ($dataorder['Detail'] as $detail) {
				$dbDatas[] = [
					'DistributorCode' => $dataorder['DistributorCode'],
					'BranchCode' => $dataorder['BranchCode'],
					'SalesRepCode' => $dataorder['SalesRepCode'],
					'RetailerCode' => $dataorder['RetailerCode'],
					'OrderNo' => $dataorder['OrderNo'],
					'OrderDate' => $dateHour,
					'ProductCode' => $detail['ChildSKUCode'],
					'OrderQtyPCS' => $detail['OrderQtyPcs'],
					'OrderQtyCS' => 0,
					'LinkFoto'	=> $dataorder['link'],
				];
			}
		};

		$collectdbDatas = collect($dbDatas);
		$chunkdbDatas = $collectdbDatas->chunk(1000);

		//Save database
		foreach ($chunkdbDatas as $chunkdbData) {
			DB::connection('192.168.11.24')->table('tds_orderdata')->insert($chunkdbData->toArray());
		}
	}
}
