<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Voucher extends Command
{
	public function __invoke()
	{
		$vouchers = DB::connection('192.168.11.24')->table('tds_voucher')->get();

		$this->post($vouchers, '/voucher', TdsEnum::VOUCHER);
	}
}
