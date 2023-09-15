<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class MasterStore extends Command
{
	public function __invoke()
	{
		$stores = DB::connection('192.168.11.24')->table('tds_storemaster')
			->whereNotNull('SiteCode')
			->get();

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
				'StoreType' => +$store->StoreType,
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
	}
}
