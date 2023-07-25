<?php

namespace App\Commands;

use App\Enums\AreaEnum;
use App\Mail\DsrCSAJ;
use App\Mail\DsrCSAS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DailySalesReportMail
{
	public function __invoke()
	{
		// $csajUser = $this->emailDestiny(AreaEnum::CSAJ_TEXT);

		// $csasUser = $this->emailDestiny(AreaEnum::CSAS_TEXT);

		Mail::to('pandu.sanjaya@csahome.com')
			->send(new DsrCSAJ());

		Mail::to('pandu.sanjaya@csahome.com')
			->send(new DsrCSAS());
	}

	public function emailDestiny(string $area)
	{
		$datas = DB::table('emails')
			->where('region', $area)
			// ->where('module', 'DSR')
			->get('name')
			->toArray();

		$arrayData = [];

		foreach ($datas as $data) {
			$arrayData[] = $data->name;
		};

		return $arrayData;
	}
}
