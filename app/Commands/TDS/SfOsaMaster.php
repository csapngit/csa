<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Seller extends Command
{
	public function __invoke()
	{
		$sfOsaMaster = DB::connection('192.168.11.24')->table('tds_osa')->get();

		$this->post($sfOsaMaster, '/sf-osa-master', TdsEnum::SF_OSA_MASTER);
	}
}
