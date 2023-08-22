<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class WorkdayService
{
	protected $timegone_index;
	protected $workDay;

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
		];

		return $dates;
	}
}
