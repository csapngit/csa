<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('emails')->insert([
			[
				'region' => 'CSAJ',
				'name' => 'iman.adehermawan@csahome.com',
			],
			[
				'region' => 'CSAJ',
				'name' => 'arbi.misbah@csahome.com',
			],
			[
				'region' => 'CSAJ',
				'name' => 'pandu.sanjaya@csahome.com',
			],
			[
				'region' => 'CSAS',
				'name' => 'abdul.rasyid@csahome.com',
			],
			[
				'region' => 'CSAS',
				'name' => 'mesakh@csahome.com'
			]
		]);
	}
}
