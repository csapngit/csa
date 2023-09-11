<?php

namespace App\Services;

use App\Enums\AreaEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DailySalesReportService extends WorkdayService
{
	private $table;

	public function __construct()
	{
		$this->table = DB::table('daily_sales_reports')
			->rightJoin('master_sales', 'daily_sales_reports.so_salesperson_id', 'master_sales.sr_code')
			// ->leftJoin('target_dsrs', 'master_sales.mapping', 'target_dsrs.mapping')
			->select([
				'master_sales.regional',
				'master_sales.branch_name',
				'daily_sales_reports.so_salesperson_id',
				'daily_sales_reports.cid',
				'master_sales.mapping',
				// 'target_dsrs.target_sales',
				'daily_sales_reports.sales_order',
				'daily_sales_reports.delivery_order',
				'daily_sales_reports.ar_invoice',
			]);

		// $this->table->where('cid', 'CJA0008713')->where('so_salesperson_id', 'SR120')->update(['mapping' => 'E-COMM']);
		// $this->table->where('cid', 'CJA0008692')->where('so_salesperson_id', '190SR550')->update(['mapping' => 'E-COMM']);
	}

	/**
	 * @property array|string $area
	 */
	public function dsrByChannel($area)
	{
		if ($area == 'CSAJ') {
			$target_dsrs = DB::table('target_dsrs')
				->where('area', $area)
				// ->whereNotIn('mapping', ['', 'act'])
				->get()
				->groupBy('mapping');

			// dd($target_dsrs);

			$channels = $this->table->where('master_sales.regional', $area)
				->where('master_sales.mapping', '!=', '')
				->whereNotIn('master_sales.mapping', ['act', 'wse', 'e-maping', 'sub 3in1'])
				->get()
				->groupBy('mapping');

			// dd($channels['PRESELL PARETO']);

			//Change some SR to E-COMM
			foreach ($channels['PRESELL PARETO'] as $key => $channelsPareto) {
				// dd($channelsPareto);
				if (($channelsPareto->cid == 'CJA0008713' && $channelsPareto->so_salesperson_id == 'SR120') || ($channelsPareto->cid == 'CJA0008692' && $channelsPareto->so_salesperson_id == '190SR550')) {
					$channelsPareto->mapping = 'E-COMM';
					$channels['E-COMM'][] = $channelsPareto;
					unset($channels['PRESELL PARETO'][$key]);
					// dd($channels);
				}
			}

			$channel_DSRs = [];

			foreach ($target_dsrs as $key => $target_dsr) {

				// dd($target_dsr);

				$channel_DSRs[strtoupper($key)] = [
					'so_open' => 0,
					'delivery_order' => 0,
					'ar_invoice' => 0,
					'sales_total' => 0,
					'monthly_target' => $target_dsr->sum('target_sales'),
					'index_archive' => 0,
					'gap' => 0,
				];
			}

			foreach ($channels as $key => $channel) {
				$so_open = $channel->sum('sales_order');
				$delivery_order = $channel->sum('delivery_order');
				$ar_invoice = $channel->sum('ar_invoice');
				$sales_total = $so_open + $delivery_order + $ar_invoice;
				$monthly_target = $channel_DSRs[strtoupper($key)]['monthly_target'];
				// $monthly_target = 0;
				$gap = $monthly_target - $sales_total;

				$index_archive = 0;
				if ($sales_total > 0 && $monthly_target > 0) {
					$index_archive = $sales_total / $monthly_target * 100;
				}

				$channel_DSRs[strtoupper($key)]['so_open'] = $so_open;
				$channel_DSRs[strtoupper($key)]['delivery_order'] = $delivery_order;
				$channel_DSRs[strtoupper($key)]['ar_invoice'] = $ar_invoice;
				$channel_DSRs[strtoupper($key)]['sales_total'] = $sales_total;
				$channel_DSRs[strtoupper($key)]['index_archive'] = $index_archive;
				$channel_DSRs[strtoupper($key)]['gap'] = $gap;
				// }
			}

			$total_channel_so_open = array_sum(array_column($channel_DSRs, 'so_open'));
			$total_channel_delivery_order = array_sum(array_column($channel_DSRs, 'delivery_order'));
			$total_channel_ar_invoice = array_sum(array_column($channel_DSRs, 'ar_invoice'));
			$total_channel_sales_total = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;
			$total_channel_monthly_target = array_sum(array_column($channel_DSRs, 'monthly_target'));
			$total_channel_gap = $total_channel_monthly_target - $total_channel_sales_total;

			$total_index_archive = 0;
			if ($total_channel_sales_total > 0 && $total_channel_monthly_target > 0) {
				$total_index_archive = $total_channel_sales_total / $total_channel_monthly_target * 100;
			}

			$best_estimate = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;

			$achv_vs_target = 0;
			if ($best_estimate != 0 && $total_channel_monthly_target != 0) {
				$achv_vs_target = $best_estimate / $total_channel_monthly_target * 100;
			}

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
		} else {
			$target_dsrs = DB::table('target_dsrs')
				->where('area', $area)
				// ->whereNotIn('mapping', ['', 'act'])
				->get();

			$channels = $this->table->where('master_sales.regional', $area)
				->where('master_sales.mapping', '!=', '')
				->whereNotIn('master_sales.mapping', ['act', 'wse', 'e-maping', 'sub 3in1'])
				->get()
				->groupBy('branch_name');

			// dd($channels);

			$channel_DSRs = [];

			foreach ($target_dsrs as $key => $target_dsr) {

				$key = $target_dsr->branch;
				$channel_DSRs[strtoupper($key)] = [
					'so_open' => 0,
					'delivery_order' => 0,
					'ar_invoice' => 0,
					'sales_total' => 0,
					'monthly_target' => $target_dsr->target_sales,
					'index_archive' => 0,
					'gap' => 0,
				];
			}

			// dd($channel_DSRs);

			foreach ($channels as $key => $channel) {
				// dd($channels);
				$so_open = $channel->sum('sales_order');
				// dd($so_open);
				$delivery_order = $channel->sum('delivery_order');
				$ar_invoice = $channel->sum('ar_invoice');
				$sales_total = $so_open + $delivery_order + $ar_invoice;
				$monthly_target = $channel_DSRs[strtoupper($key)]['monthly_target'];
				// $monthly_target = 0;
				$gap = $monthly_target - $sales_total;

				$index_archive = 0;
				if ($sales_total > 0 && $monthly_target > 0) {
					$index_archive = $sales_total / $monthly_target * 100;
				}

				$channel_DSRs[strtoupper($key)]['so_open'] = $so_open;
				$channel_DSRs[strtoupper($key)]['delivery_order'] = $delivery_order;
				$channel_DSRs[strtoupper($key)]['ar_invoice'] = $ar_invoice;
				$channel_DSRs[strtoupper($key)]['sales_total'] = $sales_total;
				$channel_DSRs[strtoupper($key)]['index_archive'] = $index_archive;
				$channel_DSRs[strtoupper($key)]['gap'] = $gap;

				// dd($channel_DSRs);
			}

			$total_channel_so_open = array_sum(array_column($channel_DSRs, 'so_open'));
			$total_channel_delivery_order = array_sum(array_column($channel_DSRs, 'delivery_order'));
			$total_channel_ar_invoice = array_sum(array_column($channel_DSRs, 'ar_invoice'));
			$total_channel_sales_total = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;
			$total_channel_monthly_target = array_sum(array_column($channel_DSRs, 'monthly_target'));
			$total_channel_gap = $total_channel_monthly_target - $total_channel_sales_total;

			$total_index_archive = 0;
			if ($total_channel_sales_total > 0 && $total_channel_monthly_target > 0) {
				$total_index_archive = $total_channel_sales_total / $total_channel_monthly_target * 100;
			}

			$best_estimate = $total_channel_so_open + $total_channel_delivery_order + $total_channel_ar_invoice;

			$achv_vs_target = 0;
			if ($best_estimate != 0 && $total_channel_monthly_target != 0) {
				$achv_vs_target = $best_estimate / $total_channel_monthly_target * 100;
			}

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

			// dd($channel_DSRs);
		}

		return $channel_DSRs;
	}

	/**
	 * @property array|string $area
	 */
	public function dsrByBranch($area)
	{
		// $area = 'CSAS';
		$target_dsrs = DB::table('target_dsrs')
			->where('area', $area)
			// ->whereNotIn('mapping', ['', 'act'])
			->get()
			->groupBy(['branch', 'mapping'])
			->toArray();

		// dd($target_dsrs);

		$dailySalesReports = $this->table
			->where('area', $area)
			->get()
			->groupBy(['branch_name', 'mapping']);

		// dd($dailySalesReports['Cengkareng']['PRESELL PARETO']);

		//If Pandeglang = CSAJ
		if (isset($dailySalesReports['Pandeglang'])) {

			// dd($dailySalesReports['Cengkareng']);
			foreach ($dailySalesReports['Cengkareng']['PRESELL PARETO'] as $key => $dsrsPareto) {
				// dd($dsrsPareto);
				if (($dsrsPareto->cid == 'CJA0008713' && $dsrsPareto->so_salesperson_id == 'SR120') || ($dsrsPareto->cid == 'CJA0008692' && $dsrsPareto->so_salesperson_id == '190SR550')) {
					$dsrsPareto->mapping = 'E-COMM';
					$dailySalesReports['Cengkareng']['E-COMM'][] = $dsrsPareto;
					unset($dailySalesReports['Cengkareng']['PRESELL PARETO'][$key]);
					// dd($channels);
				}
			}

			//Merge Pandeglang into Serang
			foreach ($dailySalesReports['Pandeglang']->keys() as $keyPandeglang) {

				foreach ($dailySalesReports['Pandeglang'][$keyPandeglang] as $keyPandeglangData) {
					$dailySalesReports['Serang'][$keyPandeglang][] = $keyPandeglangData;
				}
			}

			$dailySalesReports->forget('Pandeglang');

			//Add TSP as new key
			$dailySalesReports->put('TSP', collect());
			$dailySalesReports['TSP']->put('ISM', collect());

			foreach ($dailySalesReports->keys() as $keyBranch) {
				foreach ($dailySalesReports[$keyBranch]->keys() as $keyMapping) {
					foreach ($dailySalesReports[$keyBranch][$keyMapping] as $keyMappingData) {
						if ($keyMapping == 'ISM' && $keyBranch != 'TSP') { //Add all branch's ISM to TSP
							$dailySalesReports['TSP']['ISM'][] = $keyMappingData;
						}
					}
				}
			}

			//Remove ISM from other branches
			foreach ($dailySalesReports->keys() as $keyBranch) {
				foreach ($dailySalesReports[$keyBranch]->keys() as $keyMapping) {
					if ($keyMapping == 'ISM' && $keyBranch != 'TSP') {
						$dailySalesReports[$keyBranch]->forget('ISM');
					}
				}
			}

			// dd($dailySalesReports);

			$branch_data = [];

			foreach ($target_dsrs as $branch => $target_dsr) {
				foreach ($target_dsr as $mapping => $target) {
					$branch_data[strtoupper($branch)][$mapping] = [
						'so_open' => 0,
						'delivery_order' => 0,
						'ar_invoice' => 0,
						'sales_total' => 0,
						'monthly_target' => $target[0]->target_sales,
						'index_archive' => 0,
						'gap' => 0
					];
				}
			}

			// dd($branch_data);

			foreach ($dailySalesReports as $branch => $dailySalesReport) {

				// dd($dailySalesReport);

				foreach ($dailySalesReport as $mapping => $dsr) {

					// dd($dsr);

					$so_open = $dsr->sum('sales_order');
					$delivery_order = $dsr->sum('delivery_order');
					$ar_invoice = $dsr->sum('ar_invoice');
					$sales_total = $so_open + $delivery_order + $ar_invoice;
					// $monthly_target = $dsr->sum('target_sales');
					$monthly_target = $branch_data[strtoupper($branch)][$mapping]['monthly_target'] ?? 0;
					$gap = $monthly_target - $sales_total;
					$index_archive = 0;

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
					// dd($branch_data);
				}
			}

			// dd($branch_data);

			foreach ($branch_data as $branch => $data) {

				$total_so_open = array_sum(array_column($data, 'so_open'));
				$total_delivery_order = array_sum(array_column($data, 'delivery_order'));
				$total_ar_invoice = array_sum(array_column($data, 'ar_invoice'));
				$total_sales_total = $total_so_open + $total_delivery_order + $total_ar_invoice;
				$total_monthly_target = array_sum(array_column($data, 'monthly_target'));
				$total_gap = $total_monthly_target - $total_sales_total;

				$total_index_archive = 0;
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
		} else {
			$branch_data = [];

			foreach ($target_dsrs as $branch => $target_dsr) {
				// foreach($target_dsr)
				$branch_data[strtoupper($branch)] = [
					'so_open' => 0,
					'delivery_order' => 0,
					'ar_invoice' => 0,
					'sales_total' => 0,
					'monthly_target' => $target_dsr[""][0]->target_sales,
					'index_archive' => 0,
					'gap' => 0
				];
			}

			// dd($branch_data);

			foreach ($dailySalesReports as $branch => $dailySalesReport) {

				// dd($dailySalesReport);

				foreach ($dailySalesReport as $mapping => $dsr) {

					// dd($dsr);

					$so_open = $dsr->sum('sales_order');
					$delivery_order = $dsr->sum('delivery_order');
					$ar_invoice = $dsr->sum('ar_invoice');
					$sales_total = $so_open + $delivery_order + $ar_invoice;
					// $monthly_target = $dsr->sum('target_sales');
					$monthly_target = $branch_data[strtoupper($branch)][$mapping]['monthly_target'] ?? 0;
					$gap = $monthly_target - $sales_total;
					$index_archive = 0;

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
					// dd($branch_data);
				}
			}

			// dd($branch_data);

			foreach ($branch_data as $branch => $data) {

				$total_so_open = array_sum(array_column($data, 'so_open'));
				$total_delivery_order = array_sum(array_column($data, 'delivery_order'));
				$total_ar_invoice = array_sum(array_column($data, 'ar_invoice'));
				$total_sales_total = $total_so_open + $total_delivery_order + $total_ar_invoice;
				$total_monthly_target = $data['monthly_target'];
				$total_gap = $total_monthly_target - $total_sales_total;

				$total_index_archive = 0;
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
		}

		// dd($branch_data);

		return $branch_data;
	}
}
