<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Overdue extends Command
{
	public function __invoke()
	{
		$overdues = DB::connection('192.168.11.24')->table('tds_overdue')->get();

		$this->post($overdues, '/store-over-due', TdsEnum::OVERDUE);
	}
}
