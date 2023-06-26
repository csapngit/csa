<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Incentive extends Command
{
	public function __invoke()
	{
		$incentives = DB::connection('192.168.11.24')->table('tds_incentive')->get();

		$this->post($incentives, '/incentive', TdsEnum::INCENTIVE);
	}
}
