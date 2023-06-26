<?php

namespace App\Services;

class TrackingPaymentService
{
	public function totalPayment(array $tracking_payment_datas)
	{
		$total_payment_datas = [];

		foreach ($tracking_payment_datas as $area => $payments) {
			foreach ($payments as $branch => $payment) {

				$total_target = array_sum(array_column($payment, 'target'));
				$total_realisasi_payment = array_sum(array_column($payment, 'realisasi_payment'));
				$total_index = 0;

				if ($total_target != 0 && $total_realisasi_payment != 0) {
					$total_index = $total_realisasi_payment / $total_target * 100;
				}

				$total_payment_datas[$area][$branch] = [
					'target' => $total_target,
					'realisasi_payment' => $total_realisasi_payment,
					'index' => $total_index,
				];
			}
		}

		return $total_payment_datas;
	}
}
