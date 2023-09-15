<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Price extends Command
{
	public function __invoke()
	{
		$prices = DB::connection('192.168.11.24')->table('tds_price')
			->get();

		$prices = $prices->map(function ($price) {
			return [
				'DistributorCode' => $price->DistributorCode,
				'LocalChannelCode' => '"',
				'AreaCode' => '"',
				'AreaName' => '"',
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
	}
}
