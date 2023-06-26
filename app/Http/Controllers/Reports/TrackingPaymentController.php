<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Services\TrackingPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingPaymentController extends Controller
{
	protected TrackingPaymentService $paymentService;

	public function __construct()
	{
		$this->paymentService = new TrackingPaymentService;
	}

	public function index()
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
			->where('doc_date', 'LIKE', $date . '%')
			->get()
			->groupBy([
				'area',
				'branch',
				'segment'
			])
			->toArray();

		$tracking_payment_datas = [];

		foreach ($target_payments as $area => $target_payement) {
			foreach ($target_payement as $branch => $payments) {
				foreach ($payments as $segment => $payment) {
					foreach ($payment as $key => $value) {
						$tracking_payment_datas[$area][$branch][$segment] = [
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
					$target = $tracking_payment_datas[$area][$branch][$segments]['target'];
					$realisasi_payment = array_sum(array_column($segment, 'amount'));
					$index = 0;

					if ($target != 0 && $realisasi_payment != 0) {
						$index = $realisasi_payment / $target * 100;
					}

					$tracking_payment_datas[$area][$branch][$segments]['realisasi_payment'] = $realisasi_payment;
					$tracking_payment_datas[$area][$branch][$segments]['index'] = $index;
				}
			}
		}

		foreach ($tracking_payment_datas as $key => $value) {
			$gt = array_column($value, 'GT');

			$gt_target = array_sum(array_column($gt, 'target'));
			$gt_realisasi_payment = array_sum(array_column($gt, 'realisasi_payment'));
			$gt_index = 0;

			if ($gt_target != 0 && $gt_realisasi_payment != 0) {
				$gt_index = $gt_realisasi_payment / $gt_target * 100;
			}

			$tracking_payment_datas[$key]['TOTAL']['GT'] = [
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

			$tracking_payment_datas[$key]['TOTAL']['MT'] = [
				'target' => $mt_target,
				'realisasi_payment' => $mt_realisasi_payment,
				'index' => $mt_index,
			];
		}

		$total_payment_datas = $this->paymentService->totalPayment($tracking_payment_datas);

		return view('reports.tracking-payment.index', compact('tracking_payment_datas', 'total_payment_datas'));
	}
}
