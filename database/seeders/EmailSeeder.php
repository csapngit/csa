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
				'name' => 'pandu.sanjaya@csahome.com',
			]
		]);
	}
}
