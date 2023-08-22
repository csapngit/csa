<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TrackingPaymentService
{
	public function TrackingPayment()
	{
		$date = now()->format('Ym');

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

				$trackingpayments['total'][$area][$branch] = [
					'target' => $total_target,
					'realisasi_payment' => $total_realisasi_payment,
					'index' => $total_index,
				];
			}
		}

		return $trackingpayments;
	}
}
