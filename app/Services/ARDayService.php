<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ARDayService extends WorkdayService
{
	public function ARDays()
	{
		$firstdayoftheyear = Carbon::parse(now()->format('Y-01-01'));
		$currentday = Carbon::now();
		$daypassed = $firstdayoftheyear->diffinDays($currentday) + 1;

		$ardaysDataTargets = DB::table('target_ardays')->get()->groupBy(['area', 'branch', 'segment']);
		$ardaysDataQuery = DB::table('ardays')->get()->groupBy(['area', 'branch', 'segment', 'jenis']);

		// dd($ardaysDataQuery);

		// Set all CSAJ MT to TSP and forget other MT
		foreach ($ardaysDataQuery['CSAJ'] as $branch => $segments) {
			foreach ($segments as $segment => $jeniss) {
				if ($segment == 'MT' and $branch != 'TSP') {
					foreach ($jeniss as $jenis => $data) {
						if ($jenis == 'YTDOfftake') {
							$ardaysDataQuery['CSAJ']['TSP']['MT']['YTDOfftake'][0]->amount += $data[0]->amount;
						} else {
							$ardaysDataQuery['CSAJ']['TSP']['MT']['YTDAr'][0]->amount += $data[0]->amount;
						}
					}
					$ardaysDataQuery['CSAJ'][$branch]->forget('MT');
				}
			}
		}

		$ardaysData = [];

		foreach ($ardaysDataQuery as $region => $branchs) {
			foreach ($branchs as $branch => $segments) {
				$ardaysData[$region][$branch]['MT'] ?? $ardaysData[$region][$branch]['MT'] = null;
				$ardaysData[$region][$branch]['GT'] ?? $ardaysData[$region][$branch]['GT'] = null;
				foreach ($segments as $segment => $jeniss) {
					$ardaysData[$region][$branch][$segment]['ardays'] =  $jeniss['YTDAr'][0]->amount / $jeniss['YTDOfftake'][0]->amount * $daypassed;
					$ardaysData[$region][$branch][$segment]['target'] = $ardaysDataTargets[$region][$branch][$segment][0]->target ?? null;
					if ($ardaysData[$region][$branch][$segment]['target'] != null) {
						$ardaysData[$region][$branch][$segment]['percentage'] =   $ardaysData[$region][$branch][$segment]['target'] / $ardaysData[$region][$branch][$segment]['ardays'] * 100;
					}
				}

				if ($ardaysData[$region][$branch]['GT'] == null || $ardaysData[$region][$branch]['MT'] == null) {
					$x = 1;
				} else {
					$x = 2;
				}

				if (isset($ardaysData[$region][$branch]['GT']['target']) && isset($ardaysData[$region][$branch]['MT']['target'])) {
					$z = 2;
				} else {
					$z = 1;
				}

				$ardaysData[$region][$branch]['total']['ardays'] = ((($ardaysData[$region][$branch]['GT']['ardays'] ?? 0) + ($ardaysData[$region][$branch]['MT']['ardays'] ?? 0)) / $x);
				$ardaysData[$region][$branch]['total']['target'] = ((($ardaysData[$region][$branch]['GT']['target'] ?? 0) + ($ardaysData[$region][$branch]['MT']['target'] ?? 0)) / $z);
				$ardaysData[$region][$branch]['total']['percentage'] = $ardaysData[$region][$branch]['total']['target'] / $ardaysData[$region][$branch]['total']['ardays'] * 100;
			}
		}

		// dd($ardaysData);
		return $ardaysData;
	}
}
