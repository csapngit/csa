<?php

namespace Database\Seeders;

use App\Models\Workday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class WorkdaySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$month = now()->format('Y-m');

		$start = Carbon::parse($month)->startOfMonth();

		$end = Carbon::parse($month)->endOfMonth();

		$period = CarbonPeriod::create($start, $end);

		$data = [];

		foreach ($period as $date) {
			$data[] = [
				'date' => $date->format('Y-m-d'),
				'value' => 1
			];
		}

		Workday::insert($data);
	}
}
