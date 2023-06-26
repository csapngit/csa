<?php

namespace App\Http\Controllers\Reports;

use App\Enums\ReportEnum;
use App\Enums\UserRoleEnum;
use App\Exports\Reports\SoMonitoringExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSoMonitoringRequest;
use App\Http\Requests\UpdateSoMonitoringRequest;
use App\Models\SoMonitoring;
use App\Models\SyncReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SoMonitoringController extends Controller
{
	public function index(Request $request)
	{
		/** @var User $user */
		$user = auth()->user();

		$regions = ReportEnum::REGION;
		$statuses = ReportEnum::STATUS;

		$soMonitorings = DB::table('so_monitorings');

		$userAuth = DB::table('users')
			->join('master_areas', 'users.area', 'master_areas.id')
			->join('master_branches', 'users.branch', 'master_branches.id')
			->where('users.id', $user->id)
			->get([
				'users.name',
				'users.username',
				'master_areas.inisial',
				'master_branches.BranchName'
			])->toArray();

		$getAreaUser = $userAuth[0]->inisial;

		$getBranchUser = strtolower($userAuth[0]->BranchName);

		$getUsernameUser = $userAuth[0]->username;

		// Auth Region Manager
		if ($user->role == UserRoleEnum::RM) {
			$soMonitorings = $soMonitorings->where('Area', $getAreaUser);
		}

		// Auth Branch Manager
		if ($user->role == UserRoleEnum::BM) {
			$soMonitorings = $soMonitorings->where('cabang', $getBranchUser);
		}

		// Auth SPV
		if ($user->role == UserRoleEnum::SPV) {
			$soMonitorings = $soMonitorings
				->join('master_sales', 'so_monitorings.sales_per_id', 'master_sales.sales_code')
				->where('master_sales.spv_code', $getUsernameUser);
		}

		// Auth SR
		if ($user->role == UserRoleEnum::SR) {
			$soMonitorings = $soMonitorings->where('sales_per_id', $getUsernameUser);
		}

		/** DATA SO HEADER */
		$soHeaders = $soMonitorings
			->select([
				'so_monitorings.area',
				'so_monitorings.branch',
				'so_monitorings.type',
				'so_monitorings.qty_order',
				'so_monitorings.total_order',
				'so_monitorings.qty_shipper',
				'so_monitorings.totmerch',
			])
			->get()
			->groupBy(['branch']);

		$dataSoHeader = [];

		foreach ($soHeaders as $cabang => $soHeader) {

			$table_draft = DB::table('so_monitorings')->where('type', ReportEnum::DRAFT)->where('branch', $cabang);
			$table_so = DB::table('so_monitorings')->where('type', ReportEnum::SO)->where('branch', $cabang);

			// Calculate Qty per cabang (draft and so)
			$qty_draft = $table_draft->sum('qty_order');
			$qty_so = $table_so->sum('qty_order');
			$total_qty = $qty_draft + $qty_so;

			// Calculate Amount per cabang (draft and so)
			$amount_draft = $table_draft->sum('total_order');
			$amount_so = $table_so->sum('total_order');
			$total_amount = $amount_draft + $amount_so;

			$dataSoHeader[] = [
				'area' => $soHeader[0]->area,
				'cabang' => $cabang,
				'type' => $soHeader[0]->type,
				'qty_draft' => $qty_draft,
				'qty_so' => $qty_so,
				'qty_order' => $total_qty,
				'amount_draft' => $amount_draft,
				'amount_so' => $amount_so,
				'total_order' => $total_amount,
				'qty_shipper' => $soHeader->sum('qty_shipper'),
				'totmerch' => $soHeader->sum('totmerch'),
				'index' => $soHeader->sum('totmerch') / $total_amount * 100,
			];
		}

		// dd($dataSoHeader);

		$qtyOrder = array_sum(array_column($dataSoHeader, 'qty_order'));
		$totalOrder = array_sum(array_column($dataSoHeader, 'total_order'));
		$qtyShipper = array_sum(array_column($dataSoHeader, 'qty_shipper'));
		$totalMerch = array_sum(array_column($dataSoHeader, 'totmerch'));

		$totalIndex = 0;

		if ($totalOrder && $totalMerch != 0) {
			$totalIndex = $totalMerch / $totalOrder * 100;
		}

		/** ALL DATA FOR GM */
		$dataByRegions = [];

		$overallDataRegion = [];
		if ($user->role == UserRoleEnum::GM) {

			$gm_table_draft = DB::table('so_monitorings')->where('type', ReportEnum::DRAFT);
			$gm_table_so = DB::table('so_monitorings')->where('type', ReportEnum::SO);

			// Calculate Qty per cabang (draft and so)
			$gm_qty_draft = $gm_table_draft->sum('qty_order');
			$gm_qty_so = $gm_table_so->sum('qty_order');
			$gm_total_qty = $gm_qty_draft + $gm_qty_so;

			// Calculate Amount per cabang (draft and so)
			$gm_amount_draft = $gm_table_draft->sum('total_order');
			$gm_amount_so = $gm_table_so->sum('total_order');
			$gm_total_amount = $gm_amount_draft + $gm_amount_so;

			foreach ($dataSoHeader as $key => $header) {
				$dataByRegions[$header['area']][$key] = $header;
			}

			if ($dataByRegions != null) {
				// CSAJ
				$qtyOrderJakarta = array_sum(array_column($dataByRegions['CSAJ'], 'qty_order'));
				$totalOrderJakarta = array_sum(array_column($dataByRegions['CSAJ'], 'total_order'));
				$qtyShipperJakarta = array_sum(array_column($dataByRegions['CSAJ'], 'qty_shipper'));
				$totmerchJakarta = array_sum(array_column($dataByRegions['CSAJ'], 'totmerch'));

				// CSAS
				$qtyOrderSumatra = array_sum(array_column($dataByRegions['CSAS'], 'qty_order'));
				$totalOrderSumatra = array_sum(array_column($dataByRegions['CSAS'], 'total_order'));
				$qtyShipperSumatra = array_sum(array_column($dataByRegions['CSAS'], 'qty_shipper'));
				$totmerchSumatra = array_sum(array_column($dataByRegions['CSAS'], 'totmerch'));

				$dataByRegions['CSAJ'][] = [
					'qty_order' => $qtyOrderJakarta,
					'total_order' => $totalOrderJakarta,
					'qty_shipper' => $qtyShipperJakarta,
					'totmerch' => $totmerchJakarta,
					'total_index' => $totmerchJakarta / $totalOrderJakarta * 100
				];

				$dataByRegions['CSAS'][] = [
					'qty_order' => $qtyOrderSumatra,
					'total_order' => $totalOrderSumatra,
					'qty_shipper' => $qtyShipperSumatra,
					'totmerch' => $totmerchSumatra,
					'total_index' => $totmerchSumatra / $totalOrderSumatra * 100
				];
			}

			$overallDataRegion = [
				'qty_draft' => $gm_qty_draft,
				'qty_so' => $gm_qty_so,
				'total_qty' => $gm_total_qty,
				'amount_draft' => $gm_amount_draft,
				'amount_so' => $gm_amount_so,
				'total_amount' => $gm_total_amount,
			];
		}

		/** DATA SO DETAIL */
		$soDetails = $soMonitorings
			->select([
				'so_monitorings.id',
				'so_monitorings.branch',
				'so_monitorings.customer_id',
				'so_monitorings.customer_name',
				'so_monitorings.order_number',
				'so_monitorings.inventory_id',
				'so_monitorings.qty_order',
				'so_monitorings.total_order',
			])
			->get()
			->groupBy('customer_id')
			->toArray();

		$dataSoDetail = [];

		foreach ($soDetails as $customer_id => $soDetail) {

			$id = $soDetail[0]->id;
			$cabang = trim($soDetail[0]->branch);
			$customerId = trim($customer_id);
			$name = trim($soDetail[0]->customer_name);
			$order_number = trim($soDetail[0]->order_number);

			$temp = [
				'id' => $id,
				'cabang' => $cabang,
				'customer_id' => $customerId,
				'name' => $name,
				'order_number' => $order_number,
				'qty_order' => 0,
				'total_order' => 0,
				'details' => [],
			];

			foreach ($soDetail as $key => $data) {
				$temp['qty_order'] += $data->qty_order;
				$temp['total_order'] += $data->total_order;
				$temp['details'][] = [
					'inventory_id' => trim($data->inventory_id),
					'qty_order' => $data->qty_order,
					'total_order' => $data->total_order,
				];
			}

			$dataSoDetail[] = $temp;
		}

		$syncReportSo = SyncReport::where('report', ReportEnum::SO_MONITORING)
			->orderBy('created_at', 'desc')
			->first('created_at');

		$syncReportSo = $syncReportSo->created_at->format('Y-m-d H:i:s');

		return view(
			'reports.so-monitoring.index',
			compact(
				'statuses',
				'regions',
				'dataSoHeader',
				'dataByRegions',
				'overallDataRegion',
				'dataSoDetail',
				'qtyOrder',
				'totalOrder',
				'qtyShipper',
				'totalMerch',
				'totalIndex',
				'syncReportSo',
			)
		);
	}

	public function export()
	{
		$date = now()->format('Y-m-d');

		return Excel::download(new SoMonitoringExport, "So-Monitoring $date.xlsx");
	}
}
