<?php

namespace Database\Seeders;

use App\Models\SyncReport;
use Illuminate\Database\Seeder;

class SyncReportSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		SyncReport::create([
			'report' => 'SO',
			'note' => 'Daily SO Monitoring',
		]);
	}
}
