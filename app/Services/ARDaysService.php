<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ARDaysService extends WorkdayService
{
	public function ARDays()
	{
		$firstdayoftheyear = Carbon::parse(now()->format('Y-01-01'));
		$currentday = Carbon::now();
		$daypassed = $firstdayoftheyear->diffinDays($currentday);

		$ardaysDataTargets = DB::table('target_ardays')->get()->groupBy(['area', 'branch', 'segment']);
		$ardaysDataQuery = DB::table('ardays')->get()->groupBy(['area', 'branch', 'segment', 'jenis']);

		// Set all CSAJ MT to TSP and Forget other MT
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
				foreach ($segments as $segment => $jeniss) {
					$ardaysData[$region][$branch][$segment]['ardays'] =  $jeniss['YTDAr'][0]->amount / $jeniss['YTDOfftake'][0]->amount * $daypassed;
					$ardaysData[$region][$branch][$segment]['target'] = $ardaysDataTargets[$region][$branch][$segment][0]->target ?? '';
					if ($ardaysData[$region][$branch][$segment]['target'] != '') {
						$ardaysData[$region][$branch][$segment]['percentage'] = $ardaysData[$region][$branch][$segment]['ardays'] / $ardaysData[$region][$branch][$segment]['target'] * 100;
					} else {
						$ardaysData[$region][$branch][$segment]['percentage'] = '';
					}
				}
			}
		}

		// dd($ardaysData);
		return $ardaysData;
	}
}
