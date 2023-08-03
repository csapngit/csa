<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use App\Exports\Tds\OrderDetailExport;
use App\Exports\Tds\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\Api;
use App\Models\User;
use App\Traits\GetOrderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class OrderDetail
{
	public function __invoke()
	{
		$date = Carbon::now()->format('Y-m-d');

		$currentTime = Carbon::now()->format('H:i:s');

		$token = env('TOKEN_TDS');

		$arrayDataOrder = [];

		//Ini hit API pertama, ternyata hanya dipakai untuk database, tidak dipakai untuk CSV
		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => $date,
			// 'startTime' => $hour,
			// 'endTime' => $currentTime,
		]);

		$arrayDataOrder = $response['data']['data'];

		//dd($arrayDataOrder);

		$hentai = [];

		$dateHour = Carbon::now()->format('Y-m-d H:i:s');

		foreach ($arrayDataOrder as $dataorder) {
			foreach ($dataorder['Detail'] as $detail) {
				$hentai[] = [
					'DistributorCode' => $dataorder['DistributorCode'],
					'BranchCode' => $dataorder['BranchCode'],
					'SalesRepCode' => $dataorder['SalesRepCode'],
					'RetailerCode' => $dataorder['RetailerCode'],
					'OrderNo' => $dataorder['OrderNo'],
					'OrderDate' => $dateHour,
					'ProductCode' => $detail['ChildSKUCode'],
					'OrderQtyPCS' => $detail['OrderQtyPcs'],
					'OrderQtyCS' => 0,
				];
			}
		};

		$collecthentai = collect($hentai);
		$chunkhentais = $collecthentai->chunk(200);

		//Save database
		foreach ($chunkhentais as $chunkhentai) {
			DB::connection('192.168.11.24')->table('tds_orddetail')->insert($chunkhentai->toArray());
		}

		$branchCodes = collect($arrayDataOrder)->groupBy('BranchCode')->keys()->toArray();

		foreach ($branchCodes as $branchCode) {
			$region = DB::connection('192.168.11.24')->table('tds_branch')->where('BranchCode', $branchCode)->first();

			$time = now();

			$headerFileName = 'OrderRemarks_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

			$detailFileName = 'OrderDetail_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

			//OrderTrait
			if ($response['data']['data'] == []) {
				return 'Data kosong';
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

			//Order Trait

			// return $detailData;

			// return $header;

			$dataRemarkOrders = $header;

			$dataDetailOrders = $detailData;

			switch ($region->AreaCode) {
				case 'CSAJ':

					foreach ($dataRemarkOrders as $dataRemarkOrder) {
						Excel::store(new OrderExport($dataRemarkOrders), '//CSAJ/' .  $headerFileName, 'sftp');
					}

					foreach ($dataDetailOrders as $dataDetailOrder) {
						Excel::store(new OrderDetailExport($dataDetailOrders), '//CSAJ/' .  $detailFileName, 'sftp');
					}

					break;

				default:

					foreach ($dataRemarkOrders as $dataRemarkOrder) {
						Excel::store(new OrderExport($dataRemarkOrders), '//CSAS/' .  $headerFileName, 'sftp');
					}

					foreach ($dataDetailOrders as $dataDetailOrder) {
						Excel::store(new OrderDetailExport($dataDetailOrders), '//CSAS/' .  $detailFileName, 'sftp');
					}

					break;
			}
		}
	}
}
