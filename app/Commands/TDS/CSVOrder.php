<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CSVOrder
{
	public function __invoke()
	{
		$date = Carbon::now()->format('Y-m-d');
		$orderDatas = DB::connection('192.168.11.24')->table('tds_orderdata')
			->where(DB::raw('Convert(char(8), OrderDate, 112)'), now()->format('Ymd'))
			->whereNull('CSV')
			->get();
		$remarksDatas = $orderDatas->unique('OrderNo');
		$orderBranches = $orderDatas->unique('BranchCode');

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
	}
}
