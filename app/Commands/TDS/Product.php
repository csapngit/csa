<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Product extends Command
{
	public function __invoke()
	{
		$products = DB::connection('192.168.11.24')->table('tds_prodmaster')->take(100)->get();

		$this->post($products, '/product-master', TdsEnum::MASTER_PRODUCT);
	}
}
