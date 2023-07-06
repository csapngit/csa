<?php

namespace App\Http\Controllers\TDS;

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

class TdsController extends Controller
{
	use GetOrderTrait;

	public function index()
	{
		$apis = Api::query()->orderBy('order')->get();

		return view('tds.index', compact('apis'));
	}

	public function order($date)
	{
		$token = env('TOKEN_TDS');

		$arrayDataOrder = [];

		$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
			'page' => 1,
			'take' => 0,
			'date' => $date,
			'startTime' => '13:00:00',
			'endTime' => '17:00:00',
		]);

		$arrayDataOrder = $response['data']['data'];

		$branchCodes = collect($arrayDataOrder)->groupBy('BranchCode')->keys()->toArray();

		foreach ($branchCodes as $branchCode) {
			$region = DB::connection('192.168.11.24')->table('tds_branch')->where('BranchCode', $branchCode)->first();

			$time = now();

			$headerFileName = 'OrderRemarks_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

			$detailFileName = 'OrderDetail_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

			$dataRemarkOrders = $this->orderRemark($branchCode);

			$dataDetailOrders = $this->orderDetail($branchCode);

			switch ($region->AreaCode) {
				case 'CSAJ':

					foreach ($dataRemarkOrders as $dataRemarkOrder) {
						Excel::store(new OrderExport($dataRemarkOrders), '//CSAJ/' .  $headerFileName, 'sftp');
					}

					foreach ($dataDetailOrders as $dataDetailOrder) {
						Excel::store(new OrderDetailExport($dataDetailOrder), '//CSAJ/' .  $detailFileName, 'sftp');
					}

					break;

				default:

					foreach ($dataRemarkOrders as $dataRemarkOrder) {
						Excel::store(new OrderExport($dataRemarkOrder), '//CSAS/' .  $headerFileName, 'sftp');
					}

					foreach ($dataDetailOrders as $dataDetailOrder) {
						Excel::store(new OrderDetailExport($dataDetailOrder), '//CSAS/' .  $detailFileName, 'sftp');
					}

					break;
			}
		}

		$hentai = [];

		foreach ($arrayDataOrder as $order) {
			foreach ($order['Detail'] as $detail) {
				$hentai[] = [
					'DistributorCode' => $order['DistributorCode'],
					'BranchCode' => $order['BranchCode'],
					'SalesRepCode' => $order['SalesRepCode'],
					'RetailerCode' => $order['RetailerCode'],
					'OrderNo' => $order['OrderNo'],
					'ProductCode' => $detail['ChildSKUCode'],
					'OrderQtyPCS' => $detail['OrderQtyPcs'],
					'OrderQtyCS' => 0,
				];
			}
		};

		DB::connection('192.168.11.24')->table('tds_orddetail')->insert($hentai);

		return 'ok';
	}

	public function masterBranch()
	{
		$branches = DB::connection('192.168.11.24')->table('tds_branch')->get();

		return $this->post($branches, '/branch-master', TdsEnum::MASTER_BRANCH);
	}

	public function masterChannel()
	{
		$channels = DB::connection('192.168.11.24')->table('tds_channel')->get();

		return $this->post($channels, '/channel-master', TdsEnum::MASTER_CHANNEL);
	}

	public function holiday()
	{
		$holidays = DB::connection('192.168.11.24')->table('tds_holiday')->get();

		return $this->post($holidays, '/holiday', TdsEnum::HOLIDAY);
	}

	public function incentive()
	{
		$incentives = DB::connection('192.168.11.24')
			->table('tds_incentive')
			->where('isPostApi', null)
			->get();

		return $this->post($incentives, '/incentive', TdsEnum::INCENTIVE, [true, 'tds_incentive']);
	}

	public function isdiscontinue($data) {
		if ($data == "N" || $data == null) {
			return $data = 0;
		} else {
			return $data = 1;
		};
	}

	public function inventory()
	{
		$inventories = DB::connection('192.168.11.24')->table('tds_inventorydata')->take(100)->get();

		$inventories = $inventories->map(function ($inventory) {
			return  [
				'DistributorCode' => $inventory->DistributorCode,
				'BranchCode' => $inventory->BranchCode,
				'SKUCode' => $inventory->SKUCode,
				'SellerCode' => $inventory->SellerCode,
				'Qty' => $inventory->Qty,
				'FromDate' => $inventory->FromDate,
				'ToDate' => $inventory->ToDate,
				'WarehouseQty' => $inventory->WarehouseQty,
				'IsDiscontinue' => $this->isdiscontinue($inventory->IsDiscontinue)
			];
		});

		// dd(json_encode($inventories, JSON_UNESCAPED_SLASHES));

		return $this->post($inventories, '/inventory-data', TdsEnum::INVENTORY);
	}

	public function invoice()
	{
		$invoices = DB::connection('192.168.11.24')->table('tds_invoice')->get();

		$invoices = $invoices->map(function ($invoice) {
			return [
				'DistributorCode' => $invoice->DistributorCode,
				'Branchcode' => $invoice->BranchCode,
				'SalesRepCode' => $invoice->SalesRepCode,
				'InvoiceNo' => $invoice->InvoiceNo,
				'InvoiceDate' => $invoice->InvoiceDate,
				'Retailercode' => $invoice->RetailerCode,
				// 'ProductCode' => $invoice->ProductCode,
				'ItemCode' => 'string',
				'Qty' => $invoice->Qty,
				'Value' => $invoice->Value,
				'BillValue' => $invoice->BillValue,
				'OrderRefNo' => $invoice->OrderRefNo,
				'BasePrice' => $invoice->BasePrice,
				'DiscValue' => $invoice->DiscValue,
				'KodeLotsell' => (string) $invoice->KodeLotsell1,
				'KodeLotsellTambahan' => (string) $invoice->KodeLotselltambahan,
				'JumlahLotsell' => $invoice->JumlahLotsell,
				'TotalVoucher' => $invoice->TotalVoucher,
			];
		});

		// dd(json_encode($invoices, JSON_UNESCAPED_SLASHES));

		return $this->post($invoices, '/invoice-data', TdsEnum::INVOICE);
	}

	public function peSurvey()
	{
		$peSurveys = DB::connection('192.168.11.24')->table('tds_pesurvey')->get();

		return $this->post($peSurveys, '/pe-question-master', TdsEnum::PE_SURVEY);
	}

	public function masterPrice()
	{
		// Edited
		$prices = DB::connection('192.168.11.24')->table('tds_price')->take(50000)->get();

		$prices = $prices->map(function ($price) {
			return [
				'DistributorCode' => $price->DistributorCode,
				'LocalChannelCode' => $price->LocalChannelCode,
				// 'AreaCode' => 'string',
				// 'AreaName' => 'string',
				'AreaCode' => $price->AreaCode,
				'AreaName' => $price->AreaName,
				'SKUCode' => $price->SKUCode,
				'GrossPrice' => $price->GrossPrice,
				'NetPriceForCashPurchase' => $price->NetPriceforcashpurchase,
				'NetPriceForCreditPurchase' => $price->NetPriceforcreditpurchase,
				'KodePricing' => $price->KodePricing,
			];
		});

		// dd($prices->take(100)->toJson());

		$prices = $prices->chunk(5000)->toArray();

		$priceData = [];

		foreach ($prices as $price) {
			$priceData[] = $this->post($price, '/pricing-data', TdsEnum::MASTER_PRICE);
		}


		return $priceData;
	}

	public function productBundle()
	{
		$productBundles = DB::connection('192.168.11.24')->table('tds_prodbundle')->get();

		return $this->post($productBundles, '/product-bundle-map', TdsEnum::PRODUCT_BUNDLE);
	}

	public function masterProduct()
	{
		$products = DB::connection('192.168.11.24')->table('tds_prodmaster')->take(100)->get();

		$products = $products->map(function ($product) {
			return  [
				'DistributorCode' => $product->DistributorCode,
				'BranchCode' => $product->BranchCode,
				'ProductCode' => $product->ProductCode,
				'PGProductCode' => $product->PGProductCode,
				'ProductFullDesc' => $product->ProductFullDesc,
				'ProductShortDesc' => $product->ProductShortDesc,
				'CategoryCode' => $product->CategoryCode,
				'CategoryName' => $product->CategoryName,
				'BrandCode' => $product->BrandCode,
				'BrandName' => $product->BrandName,
				'SubBrandCode' => $product->{'Sub-BrandCode'},
				'SubBrandName' => $product->{'Sub-BrandName'},
				'ParentSKUCode' => $product->ParentSKUCode,
				'ParentSKUName' => $product->ParentSKUName,
				'MSQSize' => $product->MSQSize,
				'CaseSize' => $product->CaseSize,
				'ProductBarcode' => $product->ProductBarcode,
				'ProductTAXPercentage' => $product->ProductTAXPercentage,
				'Size' => (float)$product->Size,
				'Flag' => $product->Flag,
				'Sequence' => (float)$product->Sequence,
				'UOM' => $product->UOM
			];
		});

		// dd(json_encode($products, JSON_UNESCAPED_SLASHES));

		return $this->post($products, '/product-master', TdsEnum::MASTER_PRODUCT);
	}

	public function productPriority()
	{
		$product_priorities = DB::connection('192.168.11.24')->table('tds_ifast')->get();

		return $this->post($product_priorities, '/product-priority', TdsEnum::PRODUCT_PRIORITY);
	}

	public function promotion()
	{
		$promotions = DB::connection('192.168.11.24')->table('tds_promotion')->get();

		return $this->post($promotions, '/promotion', TdsEnum::PROMOTION);
	}

	public function promotionPrice()
	{
		$promoPrices = DB::connection('192.168.11.24')
			->table('tds_promoprice')
			->where('isPostApi', null)
			->get();

		return $this->post($promoPrices, '/promotion-price-master', TdsEnum::PROMOTION_PRICE, [true, 'tds_promoprice']);
	}

	public function masterReason()
	{
		$reasons = DB::connection('192.168.11.24')->table('tds_reason')->get();

		return $this->post($reasons, '/reason-master', TdsEnum::MASTER_REASON);
	}

	public function return()
	{
		$returns = DB::connection('192.168.11.24')->table('tds_return')->get();

		return $this->post($returns, '/return', TdsEnum::RETURN);
	}

	public function routePlanDetail()
	{
		$routePlanDetails = DB::connection('192.168.11.24')->table('tds_route')->get();

		// return Storage::disk('public')->put('routePlanDetail.json', json_encode($routePlanDetails));

		$routePlanDetails = $routePlanDetails->chunk(5000)->toArray();

		$routeData = [];

		foreach ($routePlanDetails as $routePlanDetail) {
			$routeData[] = $this->post($routePlanDetail, '/route-plan-details', TdsEnum::ROUTE_PLAN_DETAIL);
		}

		return $routeData;
	}

	public function weekMapping()
	{
		$weekMappings = DB::connection('192.168.11.24')->table('tds_weekmapping')->get()->toJson();

		$weekMappings = json_decode($weekMappings, true);
		foreach ($weekMappings as $item) {
			$item["StartDate"] = Carbon::parse($item["StartDate"])->format('Y-m-d');
			$item["EndDate"] = Carbon::parse($item["EndDate"])->format('Y-m-d');
			$item["Week"] = (int)$item["Week"];
			$item["WeekSalesTarget"] = (int)$item["WeekSalesTarget"];
		}

		return $this->post($weekMappings, '/route-plan-details-week-map', TdsEnum::WEEK_MAPPING);
	}

	public function sbdDistribution()
	{
		$sbdDistributions = DB::connection('192.168.11.24')->table('tds_sbd')->get();

		return $this->post($sbdDistributions, '/sbd-distribution', TdsEnum::SBD);
	}

	public function sbdMerchendising()
	{
		$sbdMerchs = DB::connection('192.168.11.24')->table('tds_sbdmerc')->get();

		return $this->post($sbdMerchs, '/sbd-merchandising', TdsEnum::SBD_MERC);
	}

	public function seller()
	{
		$sellers = DB::connection('192.168.11.24')->table('tds_seller')->get();

		$sellers = $sellers->map(function ($seller) {
			return [
				'DistributorCode' => $seller->DistributorCode,
				'BranchCode' => $seller->BranchCode,
				'SalesRepCode' => $seller->SalesRepCode,
				'SalesRepName' => $seller->SalesRepName,
				'SupervisorCode' => $seller->SupervisorCode,
				'SupervisorName' => $seller->SupervisorName,
				'ManagerCode' => $seller->ManagerCode,
				'ManagerName' => $seller->ManagerName,
				'SellerType' => $seller->SellerType,
				'WarehouseCode' => $seller->WarehouseCode,
				'Gender' => $seller->Gender,
				'Address' => $seller->Address,
				'MobileNo' => $seller->MobileNo,
				'EmailID' => $seller->EmailID,
				'LoginID' => $seller->LoginID,
				'Password' => $seller->Password,
				'OtherSalesRepCode' => $seller->OtherSalesRepCode,
				'ForceSyncNbrOfStore' => 999999,
				'Avatar' => $seller->Avatar,
				'SiteCode' => $seller->SiteCode,
			];
		});

		// dd(json_encode($sellers->take(100), JSON_UNESCAPED_SLASHES));

		return $this->post($sellers, '/seller-master', TdsEnum::MASTER_SELLER);
	}

	public function sellerTarget()
	{
		$sellerTargets = DB::connection('192.168.11.24')->table('tds_sellertarget')->get();

		return $this->post($sellerTargets, '/seller-target', TdsEnum::SELLER_TARGET);
	}

	public function masterStore()
	{
		$stores = DB::connection('192.168.11.24')->table('tds_storemaster')->take(10)->get();

		$stores = $stores->map(function ($store) {
			return [
				'DistributorCode' => $store->DistributorCode,
				'BranchCode' => $store->BranchCode,
				'SalesRepCode' => $store->SalesRepCode,
				'RetailerCode' => $store->RetailerCode,
				'RetailerName' => $store->RetailerName,
				'LocalChannelCode' => $store->LocalChannelCode,
				'SubChannelCode' => $store->SubChannelCode,
				'Address1' => $store->Address1,
				'Address2' => $store->Address2,
				'Address3' => $store->Address3,
				'ContactPhoneNo' => $store->ContactPhoneNo,
				'ContactPerson' => $store->ContactPerson,
				'MobileNo' => $store->MobileNo,
				'EmailID' => "",
				'Fax' => $store->Fax,
				'Frequency' => +$store->Frequency,
				'Lat_Position' => $store->Lat_Position,
				'Long_Position' => $store->Long_Position,
				'StorePurchaseType' => +$store->StorePurchaseType,
				'StoreFlag' => $store->StoreFlag,
				'Area' => $store->Area,
				'CustomerCategory' => $store->CustomerCategory,
				'CreditLimit' => $store->CreditLimit,
				'CustomerCode' => $store->CustomerCode,
				'Reg_DateTime' => $store->Reg_DateTime,
				'Upd_DateTime' => $store->Upd_DateTime,
				'StoreType' => 0,
				'TierCustomer' => $store->TierCustomer,
				'GroupCustomer' => $store->GroupCustomer,
				'KodePricing' => (string) $store->KodePricing,
				'StatusStr' => $store->StatusStr,
				'SiteCode' => $store->SiteCode,
			];
		});

		$stores = $stores->chunk(5000);

		// dd(json_encode($stores, JSON_UNESCAPED_SLASHES));

		$storeData = [];

		foreach ($stores as $store) {
			$storeData[] = $this->post($store, '/store-master', TdsEnum::MASTER_STORE);
		}

		return $storeData;

		// return Storage::disk('public')->put('storeMaster.json', json_encode($stores));

		// return $this->post($stores, '/store-master', TdsEnum::MASTER_STORE);
	}

	public function overdue()
	{
		$overdues = DB::connection('192.168.11.24')
			->table('tds_overdue')
			->where('BranchCode', '<>', '')
			->get();

		return $this->post($overdues, '/store-over-due', TdsEnum::OVERDUE);
	}

	public function storeProgram()
	{
		$storePrograms = DB::connection('192.168.11.24')->table('tds_storeprogram')->get();

		return $this->post($storePrograms, '/store-program', TdsEnum::STORE_PROGRAM);
	}

	public function storeTarget()
	{
		$storeTargets = DB::connection('192.168.11.24')->table('tds_storetarget')->get();

		return $this->post($storeTargets, '/store-target', TdsEnum::STORE_TARGET);
	}

	public function voucher()
	{
		$vouchers = DB::connection('192.168.11.24')->table('tds_voucher')->get();

		return $this->post($vouchers, '/voucher', TdsEnum::VOUCHER);
	}

	// public function sfOsaMaster()
	// {
	// 	$sfOsaMasters = DB::connection('192.168.11.24')->table('tds_')->get();

	// 	return $this->post($sfOsaMasters, '/sf-osa-master', TdsEnum::VOUCHER);
	// }

	// public function order($date, $branchCode)
	// {
	// 	$region = DB::connection('192.168.11.24')->table('tds_branch')->where('BranchCode', $branchCode)->first();

	// 	$time = now();

	// 	$headerFileName = 'OrderRemarks_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

	// 	$detailFileName = 'OrderDetail_' . $branchCode . '_' . $time->format('Ymd') . '_' . $time->format('Hi') . '.csv';

	// 	return Excel::download(new OrderExport, 'tempOrderHeader.csv', ExcelExcel::CSV);
	// 	return Excel::download(new OrderDetailExport, 'tempOrderDetail.csv', ExcelExcel::CSV);

	// switch ($region->AreaCode) {
	// 	case 'CSAJ':
	// 		Excel::store(new OrderExport, 'CSAJ/' .  $headerFileName, 'sftp');

	// 		Excel::store(new OrderDetailExport, 'CSAJ/' .  $detailFileName, 'sftp');
	// 		break;

	// 	default:
	// 		Excel::store(new OrderExport, 'CSAS/' .  $headerFileName, 'sftp');

	// 		Excel::store(new OrderDetailExport, 'CSAS/' .  $detailFileName, 'sftp');
	// 		break;
	// }

	// 	$token = env('TOKEN_TDS');

	// 	$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
	// 		'page' => 1,
	// 		'take' => 0,
	// 		'date' => request()->date,
	// 	]);

	// 	$orders = $response->json('data');

	// 	$hentai = [];

	// 	foreach ($orders['data'] as $order) {
	// 		foreach ($order['Detail'] as $detail) {
	// 			$hentai[] = [
	// 				'DistributorCode' => $order['DistributorCode'],
	// 				'BranchCode' => $order['BranchCode'],
	// 				'SalesRepCode' => $order['SalesRepCode'],
	// 				'RetailerCode' => $order['RetailerCode'],
	// 				'OrderNo' => $order['OrderNo'],
	// 				'ProductCode' => $detail['ChildSKUCode'],
	// 				'OrderQtyPCS' => $detail['OrderQtyPcs'],
	// 				'OrderQtyCS' => 0,
	// 			];
	// 		}
	// 	};

	// 	DB::connection('192.168.11.24')->table('tds_orddetail')->insert($hentai);

	// 	return 'ok';
	// }
}
