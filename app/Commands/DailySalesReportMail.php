<?php

namespace App\Commands;

use App\Mail\DsrCSAJ;
use App\Mail\DsrCSAS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DailySalesReportMail
{
	public function __invoke()
	{
		Mail::to('csapngit@csahome.com')
			->send(new DsrCSAJ());

		Mail::to('csapngit@csahome.com')
			->send(new DsrCSAS());
	}
}
