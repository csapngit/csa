<?php

namespace App\Commands;

use App\Mail\TrackingPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TrackingPaymentMail
{
	public function __invoke()
	{
		$allUser = $this->emailDestiny();

		Mail::to($allUser)
			->send(new TrackingPayment());
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
}
