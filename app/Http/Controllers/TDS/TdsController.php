<?php

namespace App\Http\Controllers\TDS;

use App\Enums\TdsEnum;
use App\Exports\Tds\OrderDetailExport;
use App\Exports\Tds\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\Api;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class TdsController extends Controller
{
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
			'startTime' => '12:00:00',
			'endTime' => '17:00:00',
		]);

		dd($response->json('data'));

		$pagecount = $response['data']['meta']['pageCount'];

		for ($i = 1; $i <= $pagecount; $i++) {
			$response = Http::withToken($token)->get(env('API_TDS') . '/order-data', [
				'page' => $i++,
				'take' => 0,
				'date' => $date,
				'startTime' => '12:00:00',
				'endTime' => '17:00:00',
			]);

			$allData = $response['data']['data'];

			foreach ($allData as $data) {
				$arrayDataOrder[] = $data;
			}
		}

		// dd(collect($arrayDataOrder)->groupBy('BranchCode'));

		$orders = collect($arrayDataOrder)->groupBy('BranchCode');

		dd($orders);

		$branchData = [];

		foreach ($orders as $branchCode => $order) {
			dd($order);
			foreach ($order as $data) {
				$branchData[$branchCode] = $data;
			}
		}

		dd($branchData);

		return 'ok';
	}

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
		$incentives = DB::connection('192.168.11.24')->table('tds_incentive')->get();

		return $this->post($incentives, '/incentive', TdsEnum::INCENTIVE);
	}

	public function inventory()
	{
		$inventories = DB::connection('192.168.11.24')->table('tds_inventorydata')->take(100)->get();

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
				'Retailercode' => $invoice->RetailerCode,
				'InvoiceNo' => $invoice->InvoiceNo,
				'InvoiceDate' => $invoice->InvoiceDate,
				'ProductCode' => $invoice->ProductCode,
				'Qty' => $invoice->Qty,
				'BasePrice' => $invoice->BasePrice,
				'Value' => $invoice->Value,
				'DiscValue' => $invoice->DiscValue,
				'BillValue' => $invoice->BillValue,
				'OrderRefNo' => $invoice->OrderRefNo,
				'KodeLotsell' => (string) $invoice->KodeLotsell1,
				'KodeLotsellTambahan' => (string) $invoice->KodeLotselltambahan,
				'TotalVoucher' => $invoice->TotalVoucher,
				'JumlahLotsell' => $invoice->JumlahLotsell,
				'ItemCode' => 'string',
			];
		});

		return $this->post($invoices, '/invoice-data', TdsEnum::INVOICE);
	}

	public function peSurvey()
	{
		$peSurveys = DB::connection('192.168.11.24')->table('tds_pesurvey')->get();

		return $this->post($peSurveys, '/pe-question-master', TdsEnum::PE_SURVEY);
	}

	public function masterPrice()
	{
		$prices = DB::connection('192.168.11.24')->table('tds_price')->take(50000)->get();

		$prices = $prices->map(function ($price) {
			return [
				'DistributorCode' => $price->DistributorCode,
				'LocalChannelCode' => $price->LocalChannelCode,
				'AreaCode' => 'string',
				'AreaName' => 'string',
				'SKUCode' => $price->SKUCode,
				'GrossPrice' => $price->GrossPrice,
				'NetPriceForCashPurchase' => $price->NetPriceforcashpurchase,
				'NetPriceForCreditPurchase' => $price->NetPriceforcreditpurchase,
				'KodePricing' => $price->KodePricing,
			];
		});

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
		$promoPrices = DB::connection('192.168.11.24')->table('tds_promoprice')->get();

		return $this->post($promoPrices, '/promotion-price-master', TdsEnum::PROMOTION_PRICE);
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
		$weekMappings = DB::connection('192.168.11.24')->table('tds_weekmapping')->get();

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
				'ForceSyncNbrOfStore' => $seller->ForceSyncNbrOfStore,
				'Avatar' => $seller->Avatar,
				'SiteCode' => $seller->SiteCode,
			];
		});

		// dd($sellers->take(10));

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
}
