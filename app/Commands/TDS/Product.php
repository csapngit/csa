<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Product extends Command
{
	public function __invoke()
	{
		$products = DB::connection('192.168.11.24')->table('tds_prodmaster')
			->where('CategoryCode', '!=', '')
			->get();

		$products = $products->map(function ($product) {
			return  [
				'DistributorCode' => $product->DistributorCode,
				'BranchCode' => $product->BranchCode,
				'ProductCode' => $product->ProductCode,
				'PGProductCode' => $product->PGProductCode,
				'ProductFullDesc' => $product->ProductFullDesc,
				'ProductShortDesc' => $product->ProductShortDesc == '' ? '-' : $product->ProductShortDesc,
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
				'UOM' => $product->UOM,
				'SiteCode' => $product->BranchCode
			];
		});

		$products = $products->chunk(5000)->toArray();

		$productData = [];

		foreach ($products as $product) {
			$productData[] = $this->post($product, '/product-master', TdsEnum::MASTER_PRODUCT);
		}
	}
}
