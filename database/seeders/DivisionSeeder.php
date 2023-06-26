<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('divisions')->insert([
			['name' => 'IT'],
			['name' => 'FINANCE'],
			['name' => 'CLAIM'],
			['name' => 'SALES'],
			['name' => 'HRD'],
			['name' => 'LOGISTIK'],
		]);
	}
}
