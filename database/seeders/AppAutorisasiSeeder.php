<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppAutorisasiSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('app_autorisasis')->insert([
			// Kevin
			['user_id' => 1, 'menu_id' => 3, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 4, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 7, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 8, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 9, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 10, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 11, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 13, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 14, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 16, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 17, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 19, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 20, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 22, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 23, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 30, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 31, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 32, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 33, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 35, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 36, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 38, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 39, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 40, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 41, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 1, 'menu_id' => 42, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Pandu
			['user_id' => 9, 'menu_id' => 3, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 4, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 7, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 8, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 9, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 10, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 11, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 13, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 14, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 16, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 17, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 19, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 20, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 22, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 23, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 30, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 31, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 32, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 33, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 35, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 36, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 38, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 39, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 40, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 41, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 9, 'menu_id' => 42, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Pak Iman
			['user_id' => 4, 'menu_id' => 3, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 4, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 7, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 8, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 9, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 10, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 11, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 13, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 14, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 16, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 17, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 19, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 20, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 22, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 23, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 4, 'menu_id' => 30, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// IT
			['user_id' => 5, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 5, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 5, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// HRD
			['user_id' => 6, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 6, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 6, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Finance
			['user_id' => 7, 'menu_id' => 25, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 7, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 7, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Pak Yeyep
			['user_id' => 8, 'menu_id' => 26, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
			['user_id' => 8, 'menu_id' => 27, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Region Manager CSAJ
			['user_id' => 9, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// General Manager
			['user_id' => 14, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Region Manager CSAS
			['user_id' => 10, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Branch Manager BANJAR
			['user_id' => 11, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// Branch Manager Jambi
			['user_id' => 12, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// SR 112SR537
			['user_id' => 13, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],

			// SPV 190SPV13
			['user_id' => 20, 'menu_id' => 29, 'input_by' => 1, 'created_at' => \Carbon\Carbon::now()],
		]);
	}
}
