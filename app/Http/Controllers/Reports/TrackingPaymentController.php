<?php

namespace App\Http\Controllers\Reports;

use App\Enums\AreaEnum;
use App\Http\Controllers\Controller;
use App\Services\TrackingPaymentService;
use App\Mail\TrackingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TrackingPaymentController extends Controller
{
	protected TrackingPaymentService $paymentService;

	public function __construct()
	{
		$this->paymentService = new TrackingPaymentService;
	}

	public function index()
	{
		$trackingpayments = $this->paymentService->TrackingPayment();

		return view('reports.tracking-payment.index', compact('trackingpayments'));
	}

	// Send Email
	public function mail()
	{
		$allUser = $this->emailDestiny();

		Mail::to('harits.zaidmalik@csahome.com')
			->send(new TrackingPayment());

		return 'ok mantab';
	}

	public function emailDestiny()
	{
		$datas = DB::table('emails')
			->where('module', 'trackingpayment')
			->get('name')
			->toArray();

		$arrayData = [];

		foreach ($datas as $data) {
			$arrayData[] = $data->name;
		};

		return $arrayData;
	}

	// Lihat index mail yang akan dikirim
	public function mailIndex()
	{
		$dates = $this->paymentService->workday();
		// $date = now()->format('d-F-Y H:i:s');
		$trackingpayments = $this->paymentService->TrackingPayment();

		return view('mails.trackingpayment', compact('trackingpayments', 'dates'));
	}
}
