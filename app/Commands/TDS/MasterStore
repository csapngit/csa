<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class MasterStore extends Command
{
	public function __invoke()
	{
		$stores = DB::connection('192.168.11.24')->table('tds_storemaster')->get();

		$this->post($stores, '/store-master', TdsEnum::MASTER_STORE);
	}
}
