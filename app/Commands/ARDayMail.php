<?php

namespace App\Commands;

use App\Mail\Arday;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ARDayMail
{
	public function __invoke()
	{
		$allUser = $this->emailDestiny();

		Mail::to($allUser)
			->send(new Arday());
	}

	public function emailDestiny()
	{
		$datas = DB::table('emails')
			->where('module', 'arday')
			->get('name')
			->toArray();

		$arrayData = [];

		foreach ($datas as $data) {
			$arrayData[] = $data->name;
		};

		return $arrayData;
	}
}
