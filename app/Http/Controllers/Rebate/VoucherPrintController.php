<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\ProgramTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\MasterBranch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherPrintController extends Controller
{
	private $table;

	public function __construct()
	{
		$this->table = DB::table('generates');
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$branches = MasterBranch::all();

		return view('rebate.print-vouchers.index', compact('branches'));
	}

	/**
	 * Show the form for print pdf
	 */
	public function printPdf(Request $request)
	{
		$generates = $this->table
			->leftJoin('programs', 'generates.program_id', 'programs.id')
			->select(
				'generates.can_publish',
				'generates.customer_id',
				'generates.name',
				'generates.sales_person',
				'generates.shipperid',
				'generates.invcnbr',
				'generates.TotInvc',
				'programs.name as program_name',
				'programs.type_id as program_type',
				'generates.incentive_display',
				'generates.incentive_volume',
				'generates.start_date',
				'generates.end_date',
			)
			->where('generates.master_branch_id', $request->branch)
			->whereNotNull([
				'generates.shipperid',
				'generates.invcnbr',
				'generates.TotInvc',
			])
			->where('generates.printed', false)
			->where('generates.can_publish', true)
			->get();

		$generates = $generates->groupBy('customer_id')->toArray();

		$generateData = [];

		$getMonth = date('m');

		foreach ($generates as $generate) {

			$voucherNumber = $getMonth . '-' . $generate[0]->customer_id . '-' . $generate[0]->shipperid;

			$temp = [
				'voucher' => $voucherNumber,
				'customer_id' => $generate[0]->customer_id,
				'name' => $generate[0]->name,
				'sales_person' => $generate[0]->sales_person,
				'shipperid' => $generate[0]->shipperid,
				'invoice_number' => $generate[0]->invcnbr,
				'total_invoice' => $generate[0]->TotInvc,
				'programs' => [],
				'payment' => 0,
				'total_amount' => 0
			];

			foreach ($generate as $data) {

				if ($data->program_type == ProgramTypeEnum::REGULAR) {

					$temp['programs'][] = [
						'program_display' => $data->program_name . ' Display',
						'amount_display' => $data->incentive_display,
						'program_volume' => $data->program_name . ' Volume',
						'amount_volume' => $data->incentive_volume,
					];

					$temp['total_amount'] += ($data->incentive_display + $data->incentive_volume);
				}

				if ($data->program_type == ProgramTypeEnum::SESSIONAL) {
					$temp['programs'][] = [
						'program_sessional' => $data->program_name,
						'amount_sessional' => $data->incentive_volume,
					];

					$temp['total_amount'] += $data->incentive_volume;
				}
			}

			$temp['payment'] = $temp['total_invoice'] - $temp['total_amount'];

			$generateData[] = $temp;
		}

		$this->table
			->where('master_branch_id', $request->branch)
			->whereNotNull([
				'generates.shipperid',
				'generates.invcnbr',
				'generates.TotInvc',
			])
			->update([
				'printed' => true
			]);

		$generateData = collect($generateData);

		$pdf = Pdf::loadView('rebate.print-vouchers.pdf.invoice', compact('generateData'))->setPaper('a4');

		$pdf->render();

		return $pdf->stream();
	}
}
