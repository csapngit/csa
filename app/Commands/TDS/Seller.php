<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Seller extends Command
{
	public function __invoke()
	{
		$sellers = DB::connection('192.168.11.24')->table('tds_seller')->get();

		$this->post($sellers, '/seller-master', TdsEnum::MASTER_SELLER);
	}
}
