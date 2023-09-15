<?php

namespace App\Http\Controllers\Reports;

use App\Enums\AreaEnum;
use App\Http\Controllers\Controller;
use App\Services\ARDayService;
use App\Mail\Arday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ARDayController extends Controller
{
	protected ARDayService  $ardaysService;

	public function __construct()
	{
		$this->ardaysService = new ARDayService;
	}

	public function index()
	{
		$ardays = $this->ardaysService->ARdays();

		// return $ardays;
		return view('reports.arday.index', compact('ardays'));
	}

	// Send Email
	public function mail()
	{
		$allUser = $this->emailDestiny();

		Mail::to($allUser)
			->send(new Arday());

		return 'ok uhuy';
	}

	public function emailDestiny()
	{
		$datas = DB::table('emails')
			->where('module', 'ardays')
			->get('name')
			->toArray();

		$arrayData = [];

		foreach ($datas as $data) {
			$arrayData[] = $data->name;
		};

		return $arrayData;
	}

	public function mailself()
	{
		Mail::to('pandu.sanjaya@csahome.com')
			->send(new Arday());

		return 'ok uhuy';
	}

	// Lihat index mail yang akan dikirim
	public function mailIndex()
	{
		// $dates = $this->paymentService->workday();
		$date = now()->format('d-F-Y H:i:s');
		$daypassed = $this->ardaysService->daypassed();
		$ardays = $this->ardaysService->ARDays();

		return view('mails.arday', compact('ardays', 'date', 'daypassed'));
	}
}
