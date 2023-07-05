<?php

namespace Database\Seeders;

use App\Models\MasterBrand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterBrandSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('master_brands')->insert([

			[
				// 'code' => 'PTN',
				'name' => 'Pantene',
			],
			[
				// 'code' => 'HNS',
				'name' => 'H&S',
			],
			[
				// 'code' => 'REJ',
				'name' => 'Rejoice',
			],
			[
				// 'code' => 'HES',
				'name' => 'Herbal Ess',
			],
			[
				// 'code' => 'DWNY',
				'name' => 'Downy',
			],
			[
				// 'code' => 'GIL',
				'name' => 'Gillete',
			],
			[
				// 'code' => 'ORB',
				'name' => 'Oral B',
			],
			[
				// 'code' => 'OLAY',
				'name' => 'Olay',
			],
			[
				// 'code' => 'WHSP',
				'name' => 'Whisper',
			],
			[
				// 'code' => 'VIC',
				'name' => 'Vicks',
			],
			[
				// 'code' => 'AMBP',
				'name' => 'Ambipur',
			],
		]);
	}
}
