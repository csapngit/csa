<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class WorkdayService
{
	protected $timegone_index, $daypassed;
	// protected $workDay;

	public function workday()
	{
		$date = now();

		$start_of_month = Carbon::parse($date->format('Y-m'))->firstOfMonth();
		$end_of_month = Carbon::parse($date->format('Y-m'))->lastOfMonth();

		$workDay = DB::table('workdays')
			->where('date', 'LIKE', $date->format('Y-m') . '%')
			->get('value')
			->sum('value');

		$timegones = CarbonPeriod::create($start_of_month, now()->addDays(-1));

		foreach ($timegones as $timegone) {
			$temp_timegones[] = $timegone->format('Y-m-d');
		}

		$timegone = DB::table('workdays')
			->whereIn('date', $temp_timegones ?? [])
			->get('value')
			->sum('value');

		if ($workDay > 0) {
			$this->timegone_index = $timegone / $workDay * 100;
		}

		$dates = [
			'date' => $date->format('d-F-Y H:i:s'),
			'timegone_index' => $this->timegone_index,
			'workday' => $workDay,
			'timegone' => $timegone,
			'rest_of_workdays' => $workDay - $timegone,

			// 'date' => Carbon::yesterday()->format('d-F-Y H:i:s'),
			// 'timegone_index' => 100,
			// 'workday' => 24,
			// 'timegone' => 24,
			// 'rest_of_workdays' => 0,
		];

		return $dates;
	}

	public function daypassed()
	{
		$firstdayoftheyear = Carbon::parse(now()->format('Y-01-01'));
		$currentday = Carbon::now();
		$this->daypassed = $firstdayoftheyear->diffinDays($currentday) + 1;

		return $this->daypassed;
	}
}
