<?php

namespace App\Imports\TDS;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IncentiveImport implements ToCollection, WithHeadingRow
{
	public function collection(Collection $collection)
	{
		$incentives = $collection->toArray();

		dd($incentives);

		$data = [];

		foreach ($incentives as $incentive) {
			$data[] = [
				'DistributorCode' => $incentive['distributorcode'],
				'BranchCode' => $incentive['branchcode'],
				'SalesRepCode' => $incentive['salesrepcode'],
				'IncentiveCode' => $incentive['incentivecode'],
				'IncentiveName' => $incentive['incentivename'],
				'ActIncentive' => $incentive['actincentive'],
				'ObjIncentive' => $incentive['objincentive'],
				'FromDate' => $incentive['fromdate'],
				'ToDate' => $incentive['todate'],
			];
		};

		DB::connection('192.168.11.24')->table('tds_incentive')->insert($data);
	}
}
