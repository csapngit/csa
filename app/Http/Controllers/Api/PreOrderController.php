<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PreOrderController extends Controller
{

	// public function index()
	// {
	// 	// return response()->toJson([
	// 	// 	"status" => 200,
	// 	// 	"success" => true,
	// 	// 	"error" => false,
	// 	// 	"msg" => "Success get data"
	// 	// ]);
	// 	return 'Ok';
	// }

	public function store(Request $preinvoiceDatas)
	{
		$rules1 = [
			'distributorcode' => 'required',
			'branchcode' => 'required',
			'salesrepcode' => 'required',
			'retailercode' => 'required',
			'ordernumber' => 'required',
			'orderdate' => 'required',
			'ordertime' => 'required',
			'deliverydate' => 'required',
			'orderitems' => 'required'
		];

		for ($i = 0; $i < count($preinvoiceDatas['orderitems']); $i++) {
			$rules2["orderitems.{$i}.rownumber"] = 'required';
			$rules2["orderitems.{$i}.productcode"] = 'required';
			$rules2["orderitems.{$i}.qty"] = 'required';
		}

		$validator1 = Validator::make($preinvoiceDatas->all(), $rules1);
		$validator2 = Validator::make($preinvoiceDatas->all(), $rules2);

		if ($validator1->fails() || $validator2->fails()) {
			return response()->json(
				[
					'status' => 400,
					'status message' => 'Something is wrong'
				]
			);
		} else {

			$insertTime = Carbon::now()->format('Y-m-d H:i:s');

			// dd($insertTime);
			foreach ($preinvoiceDatas['orderitems'] as $key => $preinvoiceData) {
				$detailDatas[] = [
					'OrderNumber' => $preinvoiceDatas['ordernumber'],
					'rownumber' => $preinvoiceData['rownumber'],
					'productcode' => $preinvoiceData['productcode'],
					'qty' => $preinvoiceData['qty'],
					// 'InsertTime' => $insertTime
				];
			}

			$insertDetails = DB::connection('192.168.11.24')->table('tds_preorder_detail')->insert($detailDatas);

			if ($insertDetails) {
				$headerDatas[] = [
					'DistributorCode' => $preinvoiceDatas['distributorcode'],
					'BranchCode' => $preinvoiceDatas['branchcode'],
					'SalesRepCode' => $preinvoiceDatas['salesrepcode'],
					'RetailerCode' => $preinvoiceDatas['retailercode'],
					'OrderNumber' => $preinvoiceDatas['ordernumber'],
					'OrderDate' => $preinvoiceDatas['orderdate'],
					'OrderTime' => $preinvoiceDatas['ordertime'],
					'DeliveryDate' => $preinvoiceDatas['deliverydate'],
					// 'InsertTime' => $insertTime
				];

				$insertHeader = DB::connection('192.168.11.24')->table('tds_preorder_header')->insert($headerDatas);

				if ($insertHeader) {
					return response()->json(
						[
							'status' => 200,
							'status message' => 'On Progress'
						]
					);
				}
			}
		}
	}

	public function show($ordernumber)
	{

		$preorderHeader = DB::connection('192.168.11.24')->table('tds_preorder_header')->where('OrderNumber', $ordernumber)->orderBy('IsCalculated', 'DESC')->first();

		if ($preorderHeader->IsCalculated != null) {
			$preorderDetails = DB::connection('192.168.11.24')->table('tds_preorder_detail')->where('OrderNumber', $ordernumber)->get();

			$preorderDatas = [
				'status' => 200,
				'status message' => 'Calculate Complete'
			];

			$preorderDatas['results'] = [
				'distributorcode' => $preorderHeader->DistributorCode,
				'branchcode' => $preorderHeader->BranchCode,
				'salesrepcode' => $preorderHeader->SalesRepCode,
				'retailercode' => $preorderHeader->RetailerCode,
				'ordernumber' => $preorderHeader->OrderNumber,
				'orderdate' => $preorderHeader->OrderDate,
				'ordertime' => $preorderHeader->OrderTime,
				'deliverydate' => $preorderHeader->DeliveryDate,
				'totaldiscreg' => $preorderHeader->TotalDiscReg,
				'totaldisclotsell' => $preorderHeader->TotalDiscLotsell,
				'moq' => $preorderHeader->VoucherValue,
				'totalgross' => $preorderHeader->TotalGross,
				'totalnetto' => $preorderHeader->TotalNetto
			];

			foreach ($preorderDetails as $preorderDetail) {
				$preorderDatas['results']['orderitems'][] = [
					'rownumber' => $preorderDetail->rownumber,
					'productcode' => $preorderDetail->productcode,
					'qty' => $preorderDetail->Qty,
					'orderprice' => $preorderDetail->orderprice,
					'percentdisc' => $preorderDetail->percentdisc,
					'valuedisc' => $preorderDetail->valuedisc,
					'valuediscreg' => $preorderDetail->valuediscreg,
					'valuedisclotsell' => $preorderDetail->valuedisclotsell,
					'disclotsell' => $preorderDetail->valuediscvolume,
					'totaldisc' => $preorderDetail->totaldisc,
					'promotioncode' => $preorderDetail->promotioncode,
					'countpromotion' => $preorderDetail->countpromotion,
				];
			}

			return response()->json([
				$preorderDatas
			]);
		} else {
			return response()->json([
				"status" => 400,
				"status message" => "Something is wrong"
			]);
		}
	}

	// public function update(Request $request, $id)
	// {
	// 	//
	// }

	// public function destroy($id)
	// {
	// 	//
	// }
}
