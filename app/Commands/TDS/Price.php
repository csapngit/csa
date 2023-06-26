<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Price extends Command
{
	public function __invoke()
	{
		$prices = DB::connection('192.168.11.24')->table('tds_price')->get();

		$this->post($prices, '/pricing-data', TdsEnum::MASTER_PRICE);
	}
}
