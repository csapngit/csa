<?php

namespace App\Imports\TDS;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class PromoPriceImport implements ToCollection, WithHeadingRow
{
	/**
	 * @param Collection $collection
	 */
	public function collection(Collection $collection)
	{
		$promoPrices = $collection->toArray();

		$data = [];

		foreach ($promoPrices as $promoPrice) {
			$data[] = [
				'DistributorCode' => $promoPrice['distributorcode'],
				'LocalChannelCode' => $promoPrice['localchannelcode'],
				'AccountName' => $promoPrice['accountname'],
				'PromoCode' => $promoPrice['promocode'],
				'PromoName' => $promoPrice['promoname'],
				'Description' => $promoPrice['description'],
				'FromDate' => $promoPrice['fromdate'],
				'ToDate' => $promoPrice['todate'],
				'RegularPrice' => $promoPrice['regularprice'],
				'PromoPrice' => $promoPrice['promoprice'],
				'Flag' => $promoPrice['flag'],
			];
		};

		DB::connection('192.168.11.24')->table('tds_promoprice')->insert($data);
	}
}
