<?php

namespace App\Http\Controllers\Reports;

use App\Enums\AreaEnum;
use App\Http\Controllers\Controller;
use App\Services\ARDaysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ARDaysController extends Controller
{
	protected ARDaysService  $ardaysService;

	public function __construct()
	{
		$this->ardaysService = new ARDaysService;
	}

	public function index()
	{
		$ardays = $this->ardaysService->ARdays();

		// return $ardays;
		return view('reports.ardays.index', compact('ardays'));
	}

	// Send Email
	public function mail()
	{
		// $allUser = $this->emailDestiny();

		// Mail::to($allUser)
		// 	->send(new TrackingPayment());

		// return 'ok mantab';
	}

	public function emailDestiny()
	{
		// $datas = DB::table('emails')
		// 	->where('module', 'trackingpayment')
		// 	->get('name')
		// 	->toArray();

		// $arrayData = [];

		// foreach ($datas as $data) {
		// 	$arrayData[] = $data->name;
		// };

		// return $arrayData;
	}

	public function mailself()
	{
		// Mail::to('pandu.sanjaya@csahome.com')
		// 	->send(new TrackingPayment());

		// return 'ok mantab';
	}

	// Lihat index mail yang akan dikirim
	public function mailIndex()
	{
		// $dates = $this->paymentService->workday();
		// // $date = now()->format('d-F-Y H:i:s');
		// $trackingpayments = $this->paymentService->TrackingPayment();

		// return view('mails.trackingpayment', compact('trackingpayments', 'dates'));
	}
}
