<?php

namespace App\Commands\TDS;

use App\Commands\Command;
use App\Enums\TdsEnum;
use Illuminate\Support\Facades\DB;

class Invoice extends Command
{
	public function __invoke()
	{
		$invoices = DB::connection('192.168.11.24')->table('tds_invoice')->take(100)->get();

		$this->post($invoices, '/invoice-data', TdsEnum::INVOICE);
	}
}
