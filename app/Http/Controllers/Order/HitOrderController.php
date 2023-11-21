<?php

namespace App\Http\Controllers\Order;

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
use Illuminate\Support\Facades\Validator;
use Psy\Command\WhereamiCommand;

class HitOrderController extends Controller
{
	// use GetOrderTrait;

	public function index()
	{
		$apis = Api::query()->orderBy('order')->get();
		$ordernumbers = DB::connection('192.168.11.24')->table('tds_orderdata')->distinct()->select('OrderNo')
			->where(DB::raw('Convert(char(8), OrderDate, 112)'), now()->format('Ymd'))->get();

		return view('tds.index', compact('apis', 'ordernumbers'));
	}

	public function hitorder()
	{
		// return 'hit order';
		$date = Carbon::now()->format('Y-m-d');
		$token = env('TOKEN_TDS');
		$arrayDataOrder = [];

		//Hit API
		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => $date,
		]);

		// $tmp =  json_decode($response);
		// return $tmp;
		// return $response;

		$currentTime = Carbon::now()->format('H:i:s');
		$arrayDataOrder = $response['data']['data'];
		$dbDatas = [];

		$dateHour = Carbon::now()->format('Y-m-d H:i:s');


		foreach ($arrayDataOrder as $dataorder) {
			foreach ($dataorder['detail'] as $detail) {
				$dbDatas[] = [
					'DistributorCode' => $dataorder['DistributorCode'],
					'BranchCode' => $dataorder['BranchCode'],
					'SalesRepCode' => $dataorder['SalesRepCode'],
					'RetailerCode' => $dataorder['RetailerCode'],
					'OrderNo' => $dataorder['OrderNo'],
					'OrderDate' => $dateHour,
					'LinkFoto2'	=> $dataorder['link'],
					'ProductCode' => $detail['productcode'],
					// 'ProductCode' => $detail['ChildSKUCode'],
					'OrderQtyPCS' => $detail['OrderQtyPcs'],
					'OrderQtyCS' => 0,
				];
			}
		};

		$collectdbDatas = collect($dbDatas);
		$chunkdbDatas = $collectdbDatas->chunk(1000);

		//Save database
		foreach ($chunkdbDatas as $chunkdbData) {
			DB::connection('192.168.11.24')->table('tds_orderdata')->insert($chunkdbData->toArray());
		}

		return 'Hit sampai oi oi oi oi ' . $currentTime;
	}

	public function csvorder()
	{
		// return 'csv order';
		$date = Carbon::now()->format('Y-m-d');

		// $remarksDatas = DB::table('tds_orderdata')->select('OrderNo', 'SalesRepCode', 'RetailerCode', 'BranchCode', 'DistributorCode')->distinct()->get();
		//$orderDatas = DB::table('tds_orderdata')
		// $orderDatas = DB::connection('192.168.11.24')->table('tds_orddetail')
		$orderDatas = DB::connection('192.168.11.24')->table('tds_orderdata')
			->where(DB::raw('Convert(char(8), OrderDate, 112)'), now()->format('Ymd'))
			// ->where(DB::raw('Convert(char(8), OrderDate, 112)'), '20230901')
			// ->where('OrderDate', '2023-09-01 17:12:00')
			->whereNull('CSV')
			->get();
		// dd($orderDatas);
		$remarksDatas = $orderDatas->unique('OrderNo');
		$orderBranches = $orderDatas->unique('BranchCode');

		// dd($remarksDatas);

		foreach ($orderBranches as $branch) {
			//Ambil data branch dari table branch untuk tau regionnya
			$region = DB::connection('192.168.11.24')->table('tds_branch')->where('BranchCode', $branch->BranchCode)->first();

			//Buat nama file
			$remarksFileName = 'OrderRemarks_' . $branch->BranchCode . '_' . Carbon::parse($branch->OrderDate)->format('Ymd') . '_' . Carbon::parse($branch->OrderDate)->format('Hi') . '.csv';
			$detailFileName = 'OrderDetail_' . $branch->BranchCode . '_' . Carbon::parse($branch->OrderDate)->format('Ymd') . '_' . Carbon::parse($branch->OrderDate)->format('Hi') . '.csv';

			//Buat header file
			$remarks = "DistributorCode;OrderNo;SalesRepCode;PONumber;Remarks;RetailerCode;GoldenStoreStatus" . "\n";
			$detail = "DistributorCode;BranchCode;SalesRepCode;RetailerCode;OrderNo;OrderDate;UploadDate;ChildSKUCode;OrderQty;OrderQty(cases);DeliveryDate;D1;D2;D3;NonIM;DiscountAmount;DiscountRate;DiscountedPrice;GoldenStoreStatus" . "\n";

			//Ambil data yang sesuai dengan branch
			$orderRemarks = $remarksDatas->where('BranchCode', $branch->BranchCode);
			$orderDetails = $orderDatas->where('BranchCode', $branch->BranchCode);

			//Isi remarks
			foreach ($orderRemarks as $order) {
				$remarks .= $order->DistributorCode . ';' .
					$order->OrderNo . ';' .
					$order->SalesRepCode . ';' .
					null . ';' .
					null . ';' .
					$order->RetailerCode . ';' .
					null . "\n";
			}

			unset($idDatas);
			$idDatas = [];

			//Isi detail
			foreach ($orderDetails as $order) {
				$detail .= $order->DistributorCode . ';' .
					$order->BranchCode . ';' .
					$order->SalesRepCode . ';' .
					$order->RetailerCode . ';' .
					$order->OrderNo . ';' .
					Carbon::parse($order->OrderDate)->format('m/d/Y') . ';' .
					null . ';' .
					$order->ProductCode . ';' .
					$order->OrderQtyPCS . ';' .
					0 . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . ';' .
					null . "\n";

				$idDatas[] = $order->id;
			}



			// $uploadremarks = Storage::disk('sfa')->put($remarksFileName, $remarks);
			// $uploaddetail = Storage::disk('sfa')->put($detailFileName, $detail);

			// if ($uploadremarks && $uploaddetail) {
			// 	DB::table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
			// }

			switch ($region->AreaCode) {
				case 'CSAJ':

					$uploadremarks  = Storage::disk('sftp')->put('//CSAJ/' . $remarksFileName, $remarks);

					$uploaddetail  = Storage::disk('sftp')->put('//CSAJ/' . $detailFileName, $detail);

					if ($uploadremarks && $uploaddetail) {
						DB::connection('192.168.11.24')->table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
					}

					break;

				default:

					$uploadremarks  = Storage::disk('sftp')->put('//CSAS/' . $remarksFileName, $remarks);

					$uploaddetail  = Storage::disk('sftp')->put('//CSAS/' . $detailFileName, $detail);

					if ($uploadremarks && $uploaddetail) {
						DB::connection('192.168.11.24')->table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
					}

					break;
			}
		}

		return 'okay jadi csv mantap ';
	}

	public function postcsvmanual(Request $request)
	{
		$orderno = $request->orderno;

		return $this->csvmanual($orderno);
	}

	public function csvmanual($orderno)
	{
		$orderCsv = DB::connection('192.168.11.24')->table('tds_orderdata')->whereIn('OrderNo', $orderno)->get();

		$remarksDatas = $orderCsv->unique('OrderNo');
		$orderBranches = $orderCsv->unique('BranchCode');
		// dd($orderBranches);
		if ($orderCsv->isNotEmpty()) {
			foreach ($orderBranches as $branch) {
				//Ambil data branch dari table branch untuk tau regionnya
				$areacode = DB::connection('192.168.11.24')->table('tds_branch')->select('AreaCode')->where('BranchCode', $branch->BranchCode)->first();

				$currentDate = Carbon::now()->format('Y-m-d');

				//Cek count terakhir untuk penamaan file
				$getcount = DB::connection('192.168.11.24')->table('tds_csvcount')->where('csvdate', $currentDate)->orderByDesc('csvcount')->first();

				if (isset($getcount)) {
					$lastcount = $getcount->csvcount + 1;
					$lastcount = str_pad($lastcount, 4, "0", STR_PAD_LEFT);
				} else {
					$lastcount = str_pad(0, 4, "0", STR_PAD_LEFT);
				}

				//Buat nama file
				$remarksFileName = 'OrderRemarks_' . $branch->BranchCode . '_' . carbon::parse($currentDate)->format('Ymd') . '_' . $lastcount . '.csv';
				$detailFileName = 'OrderDetail_' . $branch->BranchCode . '_' . carbon::parse($currentDate)->format('Ymd') . '_' . $lastcount . '.csv';

				//Buat header file
				$remarks = "DistributorCode;OrderNo;SalesRepCode;PONumber;Remarks;RetailerCode;GoldenStoreStatus" . "\n";
				$detail = "DistributorCode;BranchCode;SalesRepCode;RetailerCode;OrderNo;OrderDate;UploadDate;ChildSKUCode;OrderQty;OrderQty(cases);DeliveryDate;D1;D2;D3;NonIM;DiscountAmount;DiscountRate;DiscountedPrice;GoldenStoreStatus" . "\n";

				//Ambil data yang sesuai dengan branch
				$orderRemarks = $remarksDatas->where('BranchCode', $branch->BranchCode);
				$orderDetails = $orderCsv->where('BranchCode', $branch->BranchCode);

				//Isi remarks
				foreach ($orderRemarks as $order) {
					$remarks .= $order->DistributorCode . ';' .
						$order->OrderNo . ';' .
						$order->SalesRepCode . ';' .
						null . ';' .
						null . ';' .
						$order->RetailerCode . ';' .
						null . "\n";
				}

				unset($idDatas);
				$idDatas = [];

				//Isi detail
				foreach ($orderDetails as $order) {
					$detail .= $order->DistributorCode . ';' .
						$order->BranchCode . ';' .
						$order->SalesRepCode . ';' .
						$order->RetailerCode . ';' .
						$order->OrderNo . ';' .
						Carbon::parse($order->OrderDate)->format('m/d/Y') . ';' .
						null . ';' .
						$order->ProductCode . ';' .
						$order->OrderQtyPCS . ';' .
						0 . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . ';' .
						null . "\n";

					$idDatas[] = $order->id;
				}

				// $uploadremarks = Storage::disk('sfa')->put($remarksFileName, $remarks);
				// $uploaddetail = Storage::disk('sfa')->put($detailFileName, $detail);

				// if ($uploadremarks && $uploaddetail) {
				// 	DB::table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
				// 	DB::connection('192.168.11.24')->table('tds_csvcount')->insert(
				// 		[
				// 			'csvdate' => carbon::parse($currentDate)->format('Y-m-d'),
				// 			'csvcount' => $lastcount
				// 		]
				// 	);
				// }

				switch ($areacode->AreaCode) {
					case "CSAJ":

						$uploadremarks  = Storage::disk('sftp')->put('//CSAJ/' . $remarksFileName, $remarks);

						$uploaddetail  = Storage::disk('sftp')->put('//CSAJ/' . $detailFileName, $detail);

						if ($uploadremarks && $uploaddetail) {
							DB::connection('192.168.11.24')->table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
							DB::connection('192.168.11.24')->table('tds_csvcount')->insert(
								[
									'csvdate' => carbon::parse($currentDate)->format('Y-m-d'),
									'csvcount' => $lastcount
								]
							);
						}

						break;

					default:

						$uploadremarks  = Storage::disk('sftp')->put('//CSAS/' . $remarksFileName, $remarks);

						$uploaddetail  = Storage::disk('sftp')->put('//CSAS/' . $detailFileName, $detail);

						if ($uploadremarks && $uploaddetail) {
							DB::connection('192.168.11.24')->table('tds_orderdata')->whereIn('id', $idDatas)->update(['CSV' => '1']);
							DB::connection('192.168.11.24')->table('tds_csvcount')->insert(
								[
									'csvdate' => carbon::parse($currentDate)->format('Y-m-d'),
									'csvcount' => $lastcount
								]
							);
						}

						break;
				}
			}

			return 'oka jadi csv mantap ';
		} else {
			return 'Uwaduh! Datanya ga ada di database, coba cari kode toko di web TDS dan cek status client hit!';
		}
	}
}
