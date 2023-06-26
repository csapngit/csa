<?php

namespace App\Services;

use App\Enums\AreaEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DailySalesReportServiceSolomon extends WorkdayService
{
	private $table;

	public function __construct()
	{
		$this->table = DB::table('daily_sales_reports');
	}

	public function dsrByChannel_CSAJ()
	{
		$channels = $this->table->where('area', AreaEnum::CSAJ_TEXT)->get()->groupBy('mapping');

		$channel_DSRs = [];

		foreach ($channels as $key => $channel) {

			$so_open = $channel->sum('sales_order');
			$delivery_order = $channel->sum('delivery_order');
			$ar_invoice = $channel->sum('ar_invoice');
			$sales_total = $so_open + $delivery_order + $ar_invoice;
			$monthly_target = $channel->sum('target_sales');
			$gap = $monthly_target - $sales_total;

			if ($sales_total > 0 && $monthly_target > 0) {
				$index_archive = $sales_total / $monthly_target * 100;
			}

			$channel_DSRs[strtoupper($key)] = [
				'so_open' => $so_open,
				'delivery_order' => $delivery_order,
				'ar_invoice' => $ar_invoice,
				'sales_total' => $sales_total,
				'monthly_target' => $monthly_target,
				'index_archive' => $index_archive,
				'gap' => $gap,
			];
		}

		$total_channel_so_open = array_sum(array_column($channel_DSRs, 'so_open'));
		$total_channel_delivery_order = array_sum(array_column($channel_DSRs, 'delivery_order'));
		$total_channel_ar_invoice = array_sum(array_column($channel_DSRs, 'ar_invoice'));
		$total_channel_sales_total = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;
		$total_channel_monthly_target = array_sum(array_column($channel_DSRs, 'monthly_target'));
		$total_channel_gap = $total_channel_monthly_target - $total_channel_sales_total;

		if ($total_channel_sales_total > 0 && $total_channel_monthly_target > 0) {
			$total_index_archive = $total_channel_sales_total / $total_channel_monthly_target * 100;
		}

		$best_estimate = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;
		$achv_vs_target = $best_estimate / $total_channel_monthly_target * 100;

		$acvh_vs_timegone = 0;

		if ($achv_vs_target > 0 && $this->timegone_index > 0) {
			$acvh_vs_timegone = $achv_vs_target / $this->timegone_index * 100;
		}

		$channel_DSRs['TOTAL'] = [
			'so_open' => $total_channel_so_open,
			'delivery_order' => $total_channel_delivery_order,
			'ar_invoice' => $total_channel_ar_invoice,
			'sales_total' => $total_channel_sales_total,
			'monthly_target' => $total_channel_monthly_target,
			'index_archive' => $total_index_archive,
			'gap' => $total_channel_gap,
			'best_estimate' => $best_estimate,
			'achv_vs_target' => $achv_vs_target,
			'achv_vs_timegone' => $acvh_vs_timegone,
		];

		return $channel_DSRs;
	}

	public function dsrByBranch_CSAJ()
	{
		$dailySalesReports = $this->table->where('area', AreaEnum::CSAJ_TEXT)->get()->groupBy(['branch', 'mapping']);

		$branch_data = [];

		foreach ($dailySalesReports as $branch => $dailySalesReport) {

			foreach ($dailySalesReport as $mapping => $dsr) {

				$so_open = $dsr->sum('sales_order');
				$delivery_order = $dsr->sum('delivery_order');
				$ar_invoice = $dsr->sum('ar_invoice');
				$sales_total = $so_open + $delivery_order + $ar_invoice;
				$monthly_target = $dsr->sum('target_sales');
				$gap = $monthly_target - $sales_total;

				if ($sales_total > 0 && $monthly_target > 0) {
					$index_archive = $sales_total / $monthly_target * 100;
				}

				$branch_data[strtoupper($branch)][$mapping] = [
					'so_open' => $so_open,
					'delivery_order' => $delivery_order,
					'ar_invoice' => $ar_invoice,
					'sales_total' => $sales_total,
					'monthly_target' => $monthly_target,
					'index_archive' => $index_archive,
					'gap' => $gap
				];
			}
		}

		foreach ($branch_data as $branch => $data) {

			$total_so_open = array_sum(array_column($data, 'so_open'));
			$total_delivery_order = array_sum(array_column($data, 'delivery_order'));
			$total_ar_invoice = array_sum(array_column($data, 'ar_invoice'));
			$total_sales_total = $total_so_open + $total_delivery_order + $total_ar_invoice;
			$total_monthly_target = array_sum(array_column($data, 'monthly_target'));
			$total_gap = $total_monthly_target - $total_sales_total;

			if ($total_sales_total > 0 && $total_monthly_target > 0) {
				$total_index_archive = $total_sales_total / $total_monthly_target * 100;
			}

			$branch_data[$branch]['TOTAL'] = [
				'so_open' => $total_so_open,
				'delivery_order' => $total_delivery_order,
				'ar_invoice' => $total_ar_invoice,
				'sales_total' => $total_sales_total,
				'monthly_target' => $total_monthly_target,
				'index_archive' => $total_index_archive,
				'gap' => $total_gap
			];
		}

		return $branch_data;
	}
}
