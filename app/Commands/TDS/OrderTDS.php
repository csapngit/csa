<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderTDS
{
	public function __invoke()
	{
		$date = Carbon::now()->format('Y-m-d');

		$orderDatas = DB::table('tds_orderdata')->get();

		$orderBranches = $orderDatas->unique('BranchCode');

		foreach ($orderBranches as $branch) {
			$region = DB::connection('192.168.11.24')->table('tds_branch')->where('BranchCode', $branch->BranchCode)->first();

			$remarksFileName = 'Test_OrderRemarks_' . $branch->BranchCode . '_' . Carbon::parse($branch->OrderDate)->format('Ymd') . '_' . Carbon::parse($branch->OrderDate)->format('Hi') . '.csv';

			$detailFileName = 'Test_OrderDetail_' . $branch->BranchCode . '_' . Carbon::parse($branch->OrderDate)->format('Ymd') . '_' . Carbon::parse($branch->OrderDate)->format('Hi') . '.csv';

			$orders = $orderDatas->where('BranchCode', $branch->BranchCode);

			$handleRemarks = fopen($remarksFileName, 'w+');

			$handleDetail = fopen($detailFileName, 'w+');

			fputcsv(
				$handleRemarks,
				[
					"DistributorCode",
					"OrderNo",
					"SalesRepCode",
					"PONumber",
					"Remarks",
					"RetailerCode",
					"GoldenStoreStatus",
				],
				";"
			);

			fputcsv(
				$handleDetail,
				[
					"DistributorCode",
					"BranchCode",
					"SalesRepCode",
					"RetailerCode",
					"OrderNo",
					"OrderDate",
					"UploadDate",
					"ChildSKUCode",
					"OrderQty",
					"OrderQty(cases)",
					"DeliveryDate",
					"D1",
					"D2",
					"D3",
					"NonIM",
					"DiscountAmount",
					"DiscountRate",
					"DiscountedPrice",
					"GoldenStoreStatus",
				],
				";"
			);

			foreach ($orders as $order) {
				fputcsv(
					$handleRemarks,
					[
						$order->DistributorCode,
						$order->OrderNo,
						$order->SalesRepCode,
						null,
						null,
						$order->RetailerCode,
						null
					],
					";"
				);

				fputcsv(
					$handleDetail,
					[
						$order->DistributorCode,
						$order->BranchCode,
						$order->SalesRepCode,
						$order->RetailerCode,
						$order->OrderNo,
						date('m/d/Y', strtotime($order->OrderDate)),
						null,
						$order->ProductCode,
						$order->OrderQtyPCS,
						0,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
					],
					";"
				);
			}

			switch ($region->AreaCode) {
				case 'CSAJ':

					$uploadremarks  = Storage::disk('sftp')->put('//CSAJ/' . $remarksFileName, $handleRemarks);

					$uploaddetail  = Storage::disk('sftp')->put('//CSAJ/' . $detailFileName, $handleDetail);

					break;

				default:

					$uploadremarks  = Storage::disk('sftp')->put('//CSAS/' . $remarksFileName, $handleRemarks);

					$uploaddetail  = Storage::disk('sftp')->put('//CSAS/' . $detailFileName, $handleDetail);

					break;
			}

			fclose($handleRemarks);
			fclose($handleDetail);
		}
	}
}
