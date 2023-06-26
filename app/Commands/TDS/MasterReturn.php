<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class MasterReturn extends Command
{
	public function __invoke()
	{
		$returns = DB::connection('192.168.11.24')->table('tds_return')->get();

		$this->post($returns, '/return', TdsEnum::RETURN);
	}
}
