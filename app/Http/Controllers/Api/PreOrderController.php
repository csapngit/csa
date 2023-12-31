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

			$checkOrderNumber = DB::connection('192.168.11.24')->table('tds_preorder_header')->where('OrderNumber', $preinvoiceDatas['ordernumber'])->first();

			if ($checkOrderNumber) {
				DB::connection('192.168.11.24')->table('tds_preorder_header')->where('OrderNumber', $preinvoiceDatas['ordernumber'])->delete();
				DB::connection('192.168.11.24')->table('tds_preorder_detail')->where('OrderNumber', $preinvoiceDatas['ordernumber'])->delete();
			}

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
					'OrderTime' => Carbon::parse(now())->format('H:i:s'),
					'DeliveryDate' => $preinvoiceDatas['deliverydate'],
					// 'InsertTime' => $insertTime
				];

				$insertHeader = DB::connection('192.168.11.24')->table('tds_preorder_header')->insert($headerDatas);

				if ($insertHeader) {
					return response()->json(
						[
							'status' => 200,
							'status message' => 'Order data terkirim'
						]
					);
				}
			}
		}
	}

	public function show($ordernumber)
	{

		$preorderHeader = DB::connection('192.168.11.24')->table('tds_preorder_header')
			->select(
				'DistributorCode',
				'BranchCode',
				'SalesRepCode',
				'RetailerCode',
				'OrderNumber',
				'TotalDiscReg',
				'TotalDiscLotsell',
				'MoQ',
				'MoQValue',
				'TotalGross',
				'TotalNetto',
				'IsCalculated'
			)
			->addSelect(DB::raw('convert(char(10), OrderDate, 23) as OrderDate'))
			->addSelect(DB::raw('convert(char(8), OrderTime, 8) as OrderTime'))
			->addSelect(DB::raw('convert(char(10), DeliveryDate, 23) as DeliveryDate'))
			->where('OrderNumber', $ordernumber)
			->orderBy('IsCalculated', 'DESC')->first();

		if ($preorderHeader) {
			if ($preorderHeader->IsCalculated != null) {
				$preorderDetails = DB::connection('192.168.11.24')->table('tds_preorder_detail')->where('OrderNumber', $ordernumber)->get();

				// $preorderDatas = [
				// 	'status' => 200,
				// 	'status message' => 'Calculate Complete'
				// ];

				$preorderDatas = [];

				$preorderDatas = [
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
					'moq' => $preorderHeader->MoQ,
					'moqvalue' => $preorderHeader->MoQValue,
					'totalgross' => $preorderHeader->TotalGross,
					'totalnetto' => $preorderHeader->TotalNetto
				];

				foreach ($preorderDetails as $preorderDetail) {
					$preorderDatas['orderitems'][] = [
						'rownumber' => $preorderDetail->rownumber,
						'productcode' => $preorderDetail->productcode,
						'qty' => $preorderDetail->Qty,
						'orderprice' => $preorderDetail->orderprice,
						'percentdisc' => $preorderDetail->percentdisc,
						'discreg' => $preorderDetail->discreg,
						'valuediscreg' => $preorderDetail->valuediscreg,
						'disclotsell' => $preorderDetail->disclotsell,
						'valuedisclotsell' => $preorderDetail->valuedisclotsell,
						'totaldisc' => $preorderDetail->totaldisc,
						'promotioncode' => $preorderDetail->promotioncode,
						'countpromotion' => $preorderDetail->countpromotion,
						'bonus' => $preorderDetail->isbonus,
					];
				}

				return response()->json([
					'status' => 200,
					'status message' => 'Calculate Complete',
					'results' => $preorderDatas
				]);
			} else {
				return response()->json([
					"status" => 200,
					"status message" => "On Progress"
				]);
			}
		} elseif (isEmpty($preorderHeader)) {
			return response()->json([
				"status" => 400,
				"status message" => "OrderNumber doesn't exist"
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
