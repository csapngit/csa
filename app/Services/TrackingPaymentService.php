<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrackingPaymentService extends WorkdayService
{
	public function TrackingPayment()
	{
		$date = now()->format('Ym');
		// $date = Carbon::yesterday()->format('Ym');

		$target_payments = DB::table('target_tracking_payments')
			->get()
			->groupBy([
				'area',
				'branch',
				'segment'
			])
			->toArray();

		$tracking_payments = DB::table('tracking_payments')
			// ->where('doc_date', 'LIKE', $date . '%')
			->get()
			->groupBy([
				'area',
				'branch',
				'segment'
			])
			->toArray();

		// dd($tracking_payments);

		$trackingpayments['data'] = [];
		// $trackingpayments['data'] = $tracking_payment_datas;

		foreach ($target_payments as $area => $target_payement) {
			foreach ($target_payement as $branch => $payments) {
				foreach ($payments as $segment => $payment) {
					foreach ($payment as $key => $value) {
						$trackingpayments['data'][$area][$branch][$segment] = [
							'target' => $value->target,
							'realisasi_payment' => 0,
							'index' => 0
						];
					}
				}
			}
		}

		foreach ($tracking_payments as $area => $tracking_payment) {
			foreach ($tracking_payment as $branch => $tracking_segments) {
				foreach ($tracking_segments as $segments => $segment) {
					$target = $trackingpayments['data'][$area][$branch][$segments]['target'];
					$realisasi_payment = array_sum(array_column($segment, 'amount'));
					$index = 0;

					if ($target != 0 && $realisasi_payment != 0) {
						$index = $realisasi_payment / $target * 100;
					}

					$trackingpayments['data'][$area][$branch][$segments]['realisasi_payment'] = $realisasi_payment;
					$trackingpayments['data'][$area][$branch][$segments]['index'] = $index;
				}
			}
		}

		foreach ($trackingpayments['data'] as $key => $value) {
			$gt = array_column($value, 'GT');

			$gt_target = array_sum(array_column($gt, 'target'));
			$gt_realisasi_payment = array_sum(array_column($gt, 'realisasi_payment'));
			$gt_index = 0;

			if ($gt_target != 0 && $gt_realisasi_payment != 0) {
				$gt_index = $gt_realisasi_payment / $gt_target * 100;
			}

			$trackingpayments['data'][$key]['TOTAL']['GT'] = [
				'target' => $gt_target,
				'realisasi_payment' => $gt_realisasi_payment,
				'index' => $gt_index,
			];

			$mt = array_column($value, 'MT');

			$mt_target = array_sum(array_column($mt, 'target'));
			$mt_realisasi_payment = array_sum(array_column($mt, 'realisasi_payment'));
			$mt_index = 0;

			if ($mt_target != 0 && $mt_realisasi_payment != 0) {
				$mt_index = $mt_realisasi_payment / $mt_target * 100;
			}

			$trackingpayments['data'][$key]['TOTAL']['MT'] = [
				'target' => $mt_target,
				'realisasi_payment' => $mt_realisasi_payment,
				'index' => $mt_index,
			];
		}

		$trackingpayments['total'] = [];
		// $trackingpayments['total'] = $total_payment_datas;

		foreach ($trackingpayments['data'] as $area => $payments) {
			foreach ($payments as $branch => $payment) {

				$total_target = array_sum(array_column($payment, 'target'));
				$total_realisasi_payment = array_sum(array_column($payment, 'realisasi_payment'));
				$total_index = 0;

				if ($total_target != 0 && $total_realisasi_payment != 0) {
					$total_index = $total_realisasi_payment / $total_target * 100;
				}

				// $trackingpayments['total'][$area][$branch] = [
				// 	'target' => $total_target,
				// 	'realisasi_payment' => $total_realisasi_payment,
				// 	'index' => $total_index,
				// ];

				$trackingpayments['data'][$area][$branch]['Total'] = [
					'target' => $total_target,
					'realisasi_payment' => $total_realisasi_payment,
					'index' => $total_index,
				];
			}
		}

		$totaltarget = $trackingpayments['data']['CSAJ']['TOTAL']['Total']['target'] + $trackingpayments['data']['CSAS']['TOTAL']['Total']['target'];
		$totalrealisasi = $trackingpayments['data']['CSAJ']['TOTAL']['Total']['realisasi_payment'] + $trackingpayments['data']['CSAS']['TOTAL']['Total']['realisasi_payment'];

		$achv_vs_target = 0;
		if ($totalrealisasi != 0 && $totaltarget != 0) {
			$achv_vs_target = $totalrealisasi / $totaltarget * 100;
		}

		$acvh_vs_timegone = 0;
		if ($achv_vs_target > 0 && $this->timegone_index > 0) {
			$acvh_vs_timegone = $achv_vs_target / $this->timegone_index * 100;
		}

		$trackingpayments['total']['totaltarget'] = $totaltarget;
		$trackingpayments['total']['achievement'] = $totalrealisasi;
		$trackingpayments['total']['achievetarget'] = $achv_vs_target;
		$trackingpayments['total']['achievetimegone'] = $acvh_vs_timegone;

		$date = now();

		$workDay = DB::table('workdays')
			->where('date', 'LIKE', $date->format('Y-m') . '%')
			->get('value')
			->sum('value');

		// $workDay = 24;

		foreach ($trackingpayments['data'] as $area => $areadata) {
			foreach ($areadata as $branch => $branchdata) {
				foreach ($branchdata as $segment => $segmentdata) {
					if ($segment == 'GT') {
						$trackingpayments['data'][$area][$branch]['Average']['GT'] = $trackingpayments['data'][$area][$branch][$segment]['realisasi_payment'] / $workDay;
						$avgGT = $trackingpayments['data'][$area][$branch]['Average']['GT'];
					} else if ($segment == 'MT') {
						$trackingpayments['data'][$area][$branch]['Average']['MT'] = $trackingpayments['data'][$area][$branch][$segment]['realisasi_payment'] / $workDay;;
						$avgMT = $trackingpayments['data'][$area][$branch]['Average']['MT'];
					}
				}
				$trackingpayments['data'][$area][$branch]['Average']['Total'] = $avgGT + $avgMT;
				$avgGT = 0;
				$avgMT = 0;
			}
		}

		// foreach ($trackingpayments['data'] as $area => $areadata) {
		// 	foreach ($areadata as $branch => $branchdata) {
		// 		if ($workDay > 0) {
		// 			if (array_key_exists("GT", $trackingpayments['data'][$area][$branch])) {
		// 				dd("Key exists!");
		// 			} else {
		// 				dd("Key does not exist!");
		// 			}

		// 			$trackingpayments['data'][$area][$branch]['Average']['GT'] = $trackingpayments['data'][$area][$branch]['GT']['realisasi_payment'] / $workDay;
		// 			$trackingpayments['data'][$area][$branch]['Average']['MT'] = $trackingpayments['data'][$area][$branch]['MT']['realisasi_payment'] / $workDay;
		// 		} else {
		// 			$trackingpayments['data'][$area][$branch]['Average']['GT'] = 0;
		// 			$trackingpayments['data'][$area][$branch]['Average']['MT'] = 0;
		// 		}
		// 		$trackingpayments['data'][$area][$branch]['Average']['Total'] = $trackingpayments['data'][$area][$branch]['Average']['GT'] + $trackingpayments['data'][$area][$branch]['Average']['MT'];
		// 	}
		// }

		foreach ($trackingpayments['data'] as $area => $payments) {
			foreach ($payments as $branch => $payment) {

				$total_avg_GT = array_sum(array_column($payment['Average'], 'GT'));
				$total_avg_MT = array_sum(array_column($payment['Average'], 'MT'));
				$total_avg_Total = array_sum(array_column($payment['Average'], 'Total'));

				// $trackingpayments['total'][$area][$branch] = [
				// 	'target' => $total_target,
				// 	'realisasi_payment' => $total_realisasi_payment,
				// 	'index' => $total_index,
				// ];

				$trackingpayments['data'][$area][$branch]['Total']['Average'] = [
					'GT' => $total_avg_GT,
					'MT' => $total_avg_MT,
					'Total' => $total_avg_Total,
				];
			}
		}

		$grandtotal_GT_target = $trackingpayments['data']['CSAJ']['TOTAL']['GT']['target'] + $trackingpayments['data']['CSAS']['TOTAL']['GT']['target'];
		$grandtotal_GT_realisasi = $trackingpayments['data']['CSAJ']['TOTAL']['GT']['realisasi_payment'] + $trackingpayments['data']['CSAS']['TOTAL']['GT']['realisasi_payment'];
		if ($grandtotal_GT_target != 0 && $grandtotal_GT_realisasi != 0) {
			$grandtotal_GT_index = $grandtotal_GT_realisasi / $grandtotal_GT_target * 100;
		}
		$grandtotal_MT_target = $trackingpayments['data']['CSAJ']['TOTAL']['MT']['target'] + $trackingpayments['data']['CSAS']['TOTAL']['MT']['target'];
		$grandtotal_MT_realisasi = $trackingpayments['data']['CSAJ']['TOTAL']['MT']['realisasi_payment'] + $trackingpayments['data']['CSAS']['TOTAL']['MT']['realisasi_payment'];
		if ($grandtotal_MT_target != 0 && $grandtotal_MT_realisasi != 0) {
			$grandtotal_MT_index = $grandtotal_MT_realisasi / $grandtotal_MT_target * 100;
		}
		$grandtotal_Total_target = $trackingpayments['data']['CSAJ']['TOTAL']['Total']['target'] + $trackingpayments['data']['CSAS']['TOTAL']['Total']['target'];
		$grandtotal_Total_realisasi = $trackingpayments['data']['CSAJ']['TOTAL']['Total']['realisasi_payment'] + $trackingpayments['data']['CSAS']['TOTAL']['Total']['realisasi_payment'];
		if ($grandtotal_Total_target != 0 && $grandtotal_Total_realisasi != 0) {
			$grandtotal_Total_index = $grandtotal_Total_realisasi / $grandtotal_Total_target * 100;
		}
		$grandtotal_Avg_GT = $trackingpayments['data']['CSAJ']['TOTAL']['Average']['GT'] + $trackingpayments['data']['CSAS']['TOTAL']['Average']['GT'];
		$grandtotal_Avg_MT = $trackingpayments['data']['CSAJ']['TOTAL']['Average']['MT'] + $trackingpayments['data']['CSAS']['TOTAL']['Average']['MT'];
		$grandtotal_Avg_Total = $grandtotal_Avg_GT + $grandtotal_Avg_MT;

		$trackingpayments['data']['GRANDTOTAL']['GT']['target'] = $grandtotal_GT_target;
		$trackingpayments['data']['GRANDTOTAL']['GT']['realisasi_payment'] = $grandtotal_GT_realisasi;
		$trackingpayments['data']['GRANDTOTAL']['GT']['index'] = $grandtotal_GT_index;
		$trackingpayments['data']['GRANDTOTAL']['MT']['target'] = $grandtotal_MT_target;
		$trackingpayments['data']['GRANDTOTAL']['MT']['realisasi_payment'] = $grandtotal_MT_realisasi;
		$trackingpayments['data']['GRANDTOTAL']['MT']['index'] = $grandtotal_MT_index;
		$trackingpayments['data']['GRANDTOTAL']['Total']['target'] = $grandtotal_Total_target;
		$trackingpayments['data']['GRANDTOTAL']['Total']['realisasi_payment'] = $grandtotal_Total_realisasi;
		$trackingpayments['data']['GRANDTOTAL']['Total']['index'] = $grandtotal_Total_index;
		$trackingpayments['data']['GRANDTOTAL']['Average']['GT'] = $grandtotal_Avg_GT;
		$trackingpayments['data']['GRANDTOTAL']['Average']['MT'] = $grandtotal_Avg_MT;
		$trackingpayments['data']['GRANDTOTAL']['Average']['Total'] = $grandtotal_Avg_Total;

		// dd($trackingpayments);

		return $trackingpayments;
	}
}
