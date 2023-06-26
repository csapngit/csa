<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// DB::table('customers')->insert([
		// 	[
		// 		'program_id' => 1,
		// 		'customer_id' => 0000001,
		// 		'target' => 0,
		// 		'program_tier_id' => null,
		// 		'can_publish' => true,
		// 	],
		// 	[
		// 		'program_id' => 1,
		// 		'customer_id' => 0000002,
		// 		'target' => 0,
		// 		'program_tier_id' => null,
		// 		'can_publish' => true,
		// 	],
		// 	[
		// 		'program_id' => 1,
		// 		'customer_id' => 0000003,
		// 		'target' => 0,
		// 		'program_tier_id' => null,
		// 		'can_publish' => true,
		// 	],
		// ]);
	}
}
