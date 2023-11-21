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
		$checkCSAS = DB::table('daily_sales_reports')->where('area', 'CSAS')->get();
		$checkCSAJ = DB::table('daily_sales_reports')->where('area', 'CSAJ')->get();
		$soCSAJ = DB::table('daily_sales_reports')->where('area', 'CSAJ')->sum('sales_order');
		$doCSAJ = DB::table('daily_sales_reports')->where('area', 'CSAJ')->sum('delivery_order');
		$arCSAJ = DB::table('daily_sales_reports')->where('area', 'CSAJ')->sum('ar_invoice');
		$bestCSAJ = $soCSAJ + $doCSAJ + $arCSAJ;

		$soCSAS = DB::table('daily_sales_reports')->where('area', 'CSAS')->sum('sales_order');
		$doCSAS = DB::table('daily_sales_reports')->where('area', 'CSAS')->sum('delivery_order');
		$arCSAS = DB::table('daily_sales_reports')->where('area', 'CSAS')->sum('ar_invoice');
		$bestCSAS = $soCSAS + $doCSAS + $arCSAS;


		if ($checkCSAS->isNotEmpty() && $checkCSAJ->isNotEmpty() && $bestCSAJ != 0 && $bestCSAS != 0) {
			$csajUser = $this->emailDestiny(AreaEnum::CSAJ_TEXT);

			$csasUser = $this->emailDestiny(AreaEnum::CSAS_TEXT);

			Mail::to($csajUser)
				->send(new DsrCSAJ());

			Mail::to($csasUser)
				->send(new DsrCSAS());
		}
	}

	// if ($checkCSAS->isNotEmpty() && $checkCSAJ->isNotEmpty() && $bestCSAJ != 0 && $bestCSAS != 0) {
	// $csajUser = $this->emailDestiny(AreaEnum::CSAJ_TEXT);

	// $csasUser = $this->emailDestiny(AreaEnum::CSAS_TEXT);

	// // Mail::to($csajUser)
	// // 	->send(new DsrCSAJ());

	// // Mail::to($csasUser)
	// // 	->send(new DsrCSAS());
	// // }
	// $sendcsaj = Mail::to($csajUser)
	// 	->send(new DsrCSAJ());

	// $sendcsas = Mail::to($csasUser)
	// 	->send(new DsrCSAS());


	public function emailDestiny(string $area)
	{
		$datas = DB::table('emails')
			->where('region', $area)
			->where('module', 'dsr')
			->get('name')
			->toArray();

		$arrayData = [];

		foreach ($datas as $data) {
			$arrayData[] = $data->name;
		};

		return $arrayData;
	}
}
