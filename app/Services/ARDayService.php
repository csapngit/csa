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

		//Sum double segment
		foreach ($ardaysDataQuery as $area => $branchs) {
			foreach ($branchs as $branch => $segments) {
				foreach ($segments as $segment => $jeniss) {
					foreach ($jeniss as $jenis) {
						if (count($jenis) > 1) {
							foreach ($jenis as $key => $jenisData) {
								if ($key != 0) {
									$jenis[0]->amount += $jenis[$key]->amount;
									$jenis->forget($key);
								}
							}
						}
					}
				}
			}
		}
		// dd($ardaysDataQuery);

		//Merge TANGSEL to TANGERANG SELATAN
		if (isset($ardaysDataQuery['CSAJ']['TANGSEL'])) {
			foreach ($ardaysDataQuery['CSAJ']['TANGSEL'] as $segment => $jeniss) {
				foreach ($jeniss as $jenis => $jenisData) {
					$ardaysDataQuery['CSAJ']['TANGERANG SELATAN'][$segment][$jenis][0]->amount += $jenisData[0]->amount;
				}
			}
		}
		$ardaysDataQuery['CSAJ']->forget('TANGSEL');

		//Merge BUNGO to JAMBI
		if (isset($ardaysDataQuery['CSAS']['BUNGO'])) {
			foreach ($ardaysDataQuery['CSAS']['BUNGO'] as $segment => $jeniss) {
				foreach ($jeniss as $jenis => $jenisData) {
					$ardaysDataQuery['CSAS']['JAMBI'][$segment][$jenis][0]->amount += $jenisData[0]->amount;
				}
			}
		}
		$ardaysDataQuery['CSAS']->forget('BUNGO');

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
		// dd($ardaysDataQuery);

		// $ardaysData['AVERAGE TOTAL']['GT']['target'] = 0;
		// $ardaysData['AVERAGE TOTAL']['GT']['ardays'] = 0;
		// $ardaysData['AVERAGE TOTAL']['MT']['target'] = 0;
		// $ardaysData['AVERAGE TOTAL']['MT']['ardays'] = 0;
		// $ardaysData['AVERAGE TOTAL']['TOTAL']['ardays'] = 0;


		foreach ($ardaysDataQuery as $region => $branchs) {
			$ardaysData[$region]['AVERAGE']['GT']['target'] = 0;
			$ardaysData[$region]['AVERAGE']['MT']['target'] = 0;
			$ardaysData[$region]['AVERAGE']['GT']['ardays'] = 0;
			$ardaysData[$region]['AVERAGE']['MT']['ardays'] = 0;
			$count[$region]['GT']['target'] = 0;
			$count[$region]['GT']['ardays'] = 0;
			$count[$region]['MT']['target'] = 0;
			$count[$region]['MT']['ardays'] = 0;

			////If you need average from raw data
			// $count[$region]['SUM']['GT']['YTDOfftake'] = 0;
			// $count[$region]['SUM']['GT']['YTDAr'] = 0;
			// $count[$region]['SUM']['MT']['YTDOfftake'] = 0;
			// $count[$region]['SUM']['MT']['YTDAr'] = 0;
			foreach ($branchs as $branch => $segments) {
				if ($branch != 'AVERAGE') {
					$ardaysData[$region][$branch]['MT'] ?? $ardaysData[$region][$branch]['MT'] = null;
					$ardaysData[$region][$branch]['GT'] ?? $ardaysData[$region][$branch]['GT'] = null;
					foreach ($segments as $segment => $jeniss) {
						$ardaysData[$region][$branch][$segment]['ardays'] =  $jeniss['YTDAr'][0]->amount / $jeniss['YTDOfftake'][0]->amount * $daypassed;

						////If you need average from raw data
						// $count[$region]['SUM'][$segment]['YTDOfftake'] += $jeniss['YTDOfftake'][0]->amount;
						// $count[$region]['SUM'][$segment]['YTDAr'] += $jeniss['YTDAr'][0]->amount;

						$ardaysData[$region]['AVERAGE'][$segment]['ardays'] += $ardaysData[$region][$branch][$segment]['ardays'];
						$count[$region][$segment]['ardays']++;
						$ardaysData[$region][$branch][$segment]['target'] = $ardaysDataTargets[$region][$branch][$segment][0]->target ?? null;
						if ($ardaysData[$region][$branch][$segment]['target'] != null) {
							$ardaysData[$region][$branch][$segment]['percentage'] =   $ardaysData[$region][$branch][$segment]['target'] / $ardaysData[$region][$branch][$segment]['ardays'] * 100;
						}
						if ($ardaysData[$region][$branch][$segment]['target'] != null) {
							$ardaysData[$region]['AVERAGE'][$segment]['target'] += $ardaysData[$region][$branch][$segment]['target'];
							$count[$region][$segment]['target']++;
						}
					}

					if ($ardaysData[$region][$branch]['GT'] == null || $ardaysData[$region][$branch]['MT'] == null) {
						$x = 1;
					} else {
						$x = 2;
					}

					if (isset($ardaysData[$region][$branch]['GT']['target']) && isset($ardaysData[$region][$branch]['MT']['target'])) {
						$y = 2;
					} else {
						$y = 1;
					}

					$ardaysData[$region][$branch]['total']['ardays'] = ((($ardaysData[$region][$branch]['GT']['ardays'] ?? 0) + ($ardaysData[$region][$branch]['MT']['ardays'] ?? 0)) / $x);
					$ardaysData[$region][$branch]['total']['target'] = ((($ardaysData[$region][$branch]['GT']['target'] ?? 0) + ($ardaysData[$region][$branch]['MT']['target'] ?? 0)) / $y);
					$ardaysData[$region][$branch]['total']['percentage'] = $ardaysData[$region][$branch]['total']['target'] / $ardaysData[$region][$branch]['total']['ardays'] * 100;
				}
			}
			$ardaysData[$region]['AVERAGE']['GT']['target'] = $ardaysData[$region]['AVERAGE']['GT']['target'] / $count[$region]['GT']['target'];
			$ardaysData[$region]['AVERAGE']['MT']['target'] = $ardaysData[$region]['AVERAGE']['MT']['target'] / $count[$region]['MT']['target'];
			$ardaysData[$region]['AVERAGE']['GT']['ardays'] = $ardaysData[$region]['AVERAGE']['GT']['ardays'] / $count[$region]['GT']['ardays'];
			$ardaysData[$region]['AVERAGE']['MT']['ardays'] = $ardaysData[$region]['AVERAGE']['MT']['ardays'] / $count[$region]['MT']['ardays'];
			$ardaysData[$region]['AVERAGE']['GT']['percentage'] = $ardaysData[$region]['AVERAGE']['GT']['target'] / $ardaysData[$region]['AVERAGE']['GT']['ardays'] * 100;
			$ardaysData[$region]['AVERAGE']['MT']['percentage'] = $ardaysData[$region]['AVERAGE']['MT']['target'] / $ardaysData[$region]['AVERAGE']['MT']['ardays'] * 100;


			////Average from raw data
			// $ardaysData[$region]['AVERAGE']['GT']['target'] = $ardaysData[$region]['AVERAGE']['GT']['target'] / $count[$region]['GT']['target'];
			// $ardaysData[$region]['AVERAGE']['GT']['ardays'] = $count[$region]['SUM']['GT']['YTDAr'] / $count[$region]['SUM']['GT']['YTDOfftake'] * $daypassed;
			// $ardaysData[$region]['AVERAGE']['GT']['percentage'] = $ardaysData[$region]['AVERAGE']['GT']['target'] / $ardaysData[$region]['AVERAGE']['GT']['ardays'] * 100;
			// $ardaysData[$region]['AVERAGE']['MT']['target'] = $ardaysData[$region]['AVERAGE']['MT']['target'] / $count[$region]['MT']['target'];
			// $ardaysData[$region]['AVERAGE']['MT']['ardays'] = $count[$region]['SUM']['MT']['YTDAr'] / $count[$region]['SUM']['MT']['YTDOfftake'] * $daypassed;
			// $ardaysData[$region]['AVERAGE']['MT']['percentage'] = $ardaysData[$region]['AVERAGE']['MT']['target'] / $ardaysData[$region]['AVERAGE']['MT']['ardays'] * 100;

			$ardaysData[$region]['AVERAGE']['total']['target'] = ($ardaysData[$region]['AVERAGE']['GT']['target'] + $ardaysData[$region]['AVERAGE']['MT']['target']) / 2;
			$ardaysData[$region]['AVERAGE']['total']['ardays'] = ($ardaysData[$region]['AVERAGE']['GT']['ardays'] + $ardaysData[$region]['AVERAGE']['MT']['ardays']) / 2;
			$ardaysData[$region]['AVERAGE']['total']['percentage'] = $ardaysData[$region]['AVERAGE']['total']['target'] / $ardaysData[$region]['AVERAGE']['total']['ardays'] * 100;
		}

		$ardaysData['AVERAGE TOTAL']['GT']['target'] = ($ardaysData['CSAJ']['AVERAGE']['GT']['target'] + $ardaysData['CSAS']['AVERAGE']['GT']['target']) / 2;
		$ardaysData['AVERAGE TOTAL']['GT']['ardays'] = ($ardaysData['CSAJ']['AVERAGE']['GT']['ardays'] + $ardaysData['CSAS']['AVERAGE']['GT']['ardays']) / 2;
		$ardaysData['AVERAGE TOTAL']['GT']['percentage'] = $ardaysData['AVERAGE TOTAL']['GT']['target'] / $ardaysData['AVERAGE TOTAL']['GT']['ardays'] * 100;
		$ardaysData['AVERAGE TOTAL']['MT']['target'] = ($ardaysData['CSAJ']['AVERAGE']['MT']['target'] + $ardaysData['CSAS']['AVERAGE']['MT']['target']) / 2;
		$ardaysData['AVERAGE TOTAL']['MT']['ardays'] = ($ardaysData['CSAJ']['AVERAGE']['MT']['ardays'] + $ardaysData['CSAS']['AVERAGE']['MT']['ardays']) / 2;
		$ardaysData['AVERAGE TOTAL']['MT']['percentage'] = $ardaysData['AVERAGE TOTAL']['MT']['target'] / $ardaysData['AVERAGE TOTAL']['MT']['ardays'] * 100;
		$ardaysData['AVERAGE TOTAL']['total']['target'] = ($ardaysData['AVERAGE TOTAL']['GT']['target'] + $ardaysData['AVERAGE TOTAL']['MT']['target']) / 2;
		$ardaysData['AVERAGE TOTAL']['total']['ardays'] = ($ardaysData['AVERAGE TOTAL']['GT']['ardays'] + $ardaysData['AVERAGE TOTAL']['MT']['ardays']) / 2;
		$ardaysData['AVERAGE TOTAL']['total']['percentage'] = $ardaysData['AVERAGE TOTAL']['total']['target'] / $ardaysData['AVERAGE TOTAL']['total']['ardays'] * 100;

		// dd($count);
		// dd($ardaysData);
		return $ardaysData;
	}
}
