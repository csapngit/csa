<?php

namespace App\Imports;

use App\Models\FailedImport;
use App\Models\MasterCustomer;
use App\Models\Program;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TspCustomersImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
	/**
	 * Import data from the first sheet
	 *
	 * The next sheet[1] is in Generates Import
	 */
	public function sheets(): array
	{
		return [
			0 => new TspCustomersImport(),
		];
	}

	public function collection(Collection $rows)
	{
		/** @var Program $program */
		$program = request()->program;

		// get collection excel data
		$excelData = collect($rows->toArray());

		// get customer Id from excel data
		$excelCustomerIds = $excelData->pluck('customer_id');

		// get customer id from master customer
		$masterCustomerIds = DB::table('master_customers')->pluck('CustId')->toArray();

		// trim customer id from master customer
		$masterCustomerIds = array_map('trim', $masterCustomerIds);

		// intersect by customer id from excel to master customer
		$customerIds = $excelCustomerIds->intersect($masterCustomerIds)->toArray();

		// get the different data customer id between excel and master customer
		$failCustomerIds = $excelCustomerIds->diff($masterCustomerIds);

		$now = now();

		if ($failCustomerIds->first()) {

			$batch = 1;

			$lastFailedImport = FailedImport::orderBy('id', 'desc')->first();

			if ($lastFailedImport) {
				$batch = $lastFailedImport->batch + 1; //2
			}

			$failCustomerData = [];

			foreach ($failCustomerIds as $failCustomerId) {
				$failCustomerData[] = [
					'customer_id' => $failCustomerId,
					'batch'       => $batch,
					'created_at'  => $now,
					'updated_at'  => $now,
				];
			}

			$failCustomerData = collect($failCustomerData)->chunk(500)->toArray();

			foreach ($failCustomerData as $data) {
				DB::table('failed_imports')->insert($data);
			}

			return session()->flash('warning', __('message.data_warning'));
		}

		if (collect($customerIds)->first()) {

			DB::table('customers')->where('program_id', $program->id)->delete();

			DB::table('failed_imports')->truncate();

			$excelData = $excelData->whereIn('customer_id', $customerIds)->toArray();

			$data = [];

			// $masterCustomers = DB::table('master_customers')
			// 	->whereIn('CustId', $excelCustomerIds)
			// 	->get([
			// 		'CustId',
			// 		'tier'
			// 	]);

			foreach ($excelData as $row) {

				$data[] = [
					'program_id' => +$program->id,
					'customer_id' => (string) $row['customer_id'],
					// 'target' => (float) $row['target'],
					// 'program_tier_id' => $masterCustomers->where('CustId', $row['customer_id'])->first()->tier,
					// 'can_publish' => +$row['publish'],
					// 'created_at' => $now,
					// 'updated_at' => $now,
				];
			}

			$datas = collect($data)->chunk(500)->toArray();

			foreach ($datas as $data) {
				DB::table('customers')->insert($data);
			}

			return session()->flash('success', __('message.data_uploaded'));
		}
	}
}
