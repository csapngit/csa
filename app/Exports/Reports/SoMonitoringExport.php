<?php

namespace App\Exports\Reports;

use App\Enums\ReportEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SoMonitoringExport implements WithCustomStartCell, WithHeadings, WithStyles, ShouldAutoSize, FromArray
{
	private $user;

	private $userAuth;

	private $getAreaUser;

	private $getBranchUser;

	private $getUsernameUser;

	private $qty_draft;

	private $qty_so;

	private $total_qty;

	private $amount_draft;

	private $amount_so;

	private $total_amount;

	private $qty_do;

	private $totmerch;

	public function __construct()
	{
		$this->user = auth()->user();

		$this->userAuth = DB::table('users')
			->join('master_areas', 'users.area', 'master_areas.id')
			->join('master_branches', 'users.branch', 'master_branches.id')
			->join('user_roles', 'users.role', 'user_roles.id')
			->where('users.id', $this->user->id)
			->get([
				'users.name',
				'users.username',
				'users.role',
				'user_roles.inisial as user_role',
				'master_areas.inisial',
				'master_branches.BranchName'
			])->toArray();
	}

	public function array(): array
	{
		$table = DB::table('so_monitorings');

		$this->getAreaUser = $this->userAuth[0]->inisial;

		$this->getBranchUser = $this->userAuth[0]->BranchName;

		// Auth Region Manager
		if ($this->user->role == UserRoleEnum::RM) {
			$table = $table->where('area', $this->getAreaUser);
		}

		// Auth Branch Manager
		if ($this->user->role == UserRoleEnum::BM) {
			$table = $table->where('branch', $this->getBranchUser);
		}

		// Auth SPV
		if ($this->user->role == UserRoleEnum::SPV) {
			$table = $table
				->join('master_sales', 'so_monitorings.sales_per_id', 'master_sales.sales_code')
				->where('master_sales.spv_code', $this->getUsernameUser);
		}

		$soMonitorings = $table
			->select(
				'area',
				'branch',
				'type',
				'sales_per_id',
				'shipper_id',
				'customer_id',
				'customer_name',
				'inventory_id',
				'qty_order',
				'total_order',
				'qty_shipper',
				'totmerch',
			)
			->get();

		$data = [];

		$soMonitorings = $soMonitorings->map(function ($soMonitoring) use ($data) {
			return $data[] = [
				'area' => $soMonitoring->area,
				'cabang' => trim($soMonitoring->branch),
				'sales_id' => trim($soMonitoring->sales_per_id),
				'shipper_id' => trim($soMonitoring->shipper_id),
				'customer_id' => trim($soMonitoring->customer_id),
				'billname' => trim($soMonitoring->customer_name),
				'inventory_id' => trim($soMonitoring->inventory_id),
				'qty_order' => trim($soMonitoring->qty_order),
				'total_order' => trim($soMonitoring->total_order),
				'qty_shipper' => trim($soMonitoring->qty_shipper),
				'totmerch' => trim($soMonitoring->totmerch),
			];
		});

		// dd($soMonitorings);

		$soMonitorings = $soMonitorings->toArray();

		$table_draft = DB::table('so_monitorings')->where('type', ReportEnum::DRAFT);
		$table_so = DB::table('so_monitorings')->where('type', ReportEnum::SO);

		// Calculate Qty per cabang (draft and so)
		$this->qty_draft = $table_draft->sum('qty_order');
		$this->qty_so = $table_so->sum('qty_order');
		$this->total_qty = $this->qty_draft + $this->qty_so;

		// Calculate Amount per cabang (draft and so)
		$this->amount_draft = $table_draft->sum('total_order');
		$this->amount_so = $table_so->sum('total_order');
		$this->total_amount = $this->amount_draft + $this->amount_so;

		// $this->qty_so = array_sum(array_column($soMonitorings, 'qty_order'));
		// $this->total_qty = array_sum(array_column($soMonitorings, 'total_order'));
		$this->qty_do = array_sum(array_column($soMonitorings, 'qty_shipper'));
		$this->totmerch = array_sum(array_column($soMonitorings, 'totmerch'));

		return $soMonitorings;
	}

	public function headings(): array
	{
		return [
			__('app.reports.so-monitorings.area'),
			__('app.reports.so-monitorings.cabang'),
			__('app.reports.so-monitorings.sales_id'),
			__('app.reports.so-monitorings.shipper_id'),
			__('app.reports.so-monitorings.customer_id'),
			__('app.reports.so-monitorings.billname'),
			__('app.reports.so-monitorings.inventory_id'),
			__('app.reports.so-monitorings.qty_so'),
			__('app.reports.so-monitorings.total_so'),
			__('app.reports.so-monitorings.qty_do'),
			__('app.reports.so-monitorings.totmerch'),
		];
	}

	public function startCell(): string
	{
		return 'A12';
	}

	public function styles(Worksheet $sheet)
	{
		// Set font row 1 :bold
		$sheet->getStyle(12)->getFont()->setBold(true);
		$sheet->getStyle('C2:C9')->getFont()->setBold(true);

		// Set autofilter data
		$sheet->setAutoFilter('A12:K12');

		// Set format column
		$sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('C5')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('C6')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('C7')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('C9')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
		$sheet->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

		// $sheet->setCellValue('G1', 'Test');
		$sheet
			->setCellValue('B2', __('app.reports.so-monitorings.qty_draft'))->setCellValue('C2', $this->qty_draft)
			->setCellValue('B3', __('app.reports.so-monitorings.qty_so'))->setCellValue('C3', $this->qty_so)
			->setCellValue('B4', __('app.reports.so-monitorings.qty_total'))->setCellValue('C4', $this->total_qty)
			->setCellValue('B5', __('app.reports.so-monitorings.amount_draft'))->setCellValue('C5', $this->amount_draft)
			->setCellValue('B6', __('app.reports.so-monitorings.amount_so'))->setCellValue('C6', $this->amount_so)
			->setCellValue('B7', __('app.reports.so-monitorings.total_so'))->setCellValue('C7', $this->total_amount)
			->setCellValue('B8', __('app.reports.so-monitorings.qty_do'))->setCellValue('C8', $this->qty_do)
			->setCellValue('B9', __('app.reports.so-monitorings.totmerch'))->setCellValue('C9', $this->totmerch);
	}
}
