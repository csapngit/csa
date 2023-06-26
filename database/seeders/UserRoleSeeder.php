<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('user_roles')->insert([
			[
				'inisial' => 'COO',
				'role_name' => 'Chief Operating Officer',
				'level' => '1'
			],
			[
				'inisial' => 'GM',
				'role_name' => 'General Manager',
				'level' => '2'
			],
			[
				'inisial' => 'RM',
				'role_name' => 'Region Manager',
				'level' => '3'
			],
			[
				'inisial' => 'ITM',
				'role_name' => 'IT', 'level
			 ' => '4'
			],
			[
				'inisial' => 'GTM',
				'role_name' => 'GTM Manager',
				'level' => '4'
			],
			[
				'inisial' => 'BM',
				'role_name' => 'Branch Manager',
				'level' => '5'
			],
			[
				'inisial' => 'FM',
				'role_name' => 'Finance Manager',
				'level' => '5'
			],
			[
				'inisial' => 'CAF',
				'role_name' => 'CAF',
				'level' => '6'
			],
			[
				'inisial' => 'IN',
				'role_name' => 'Inkaso',
				'level' => '7'
			],
			[
				'inisial' => 'SPV',
				'role_name' => 'SPV',
				'level' => '8'
			],
			[
				'inisial' => 'SR',
				'role_name' => 'SR',
				'level' => '9'
			],
			[
				'inisial' => 'TSP',
				'role_name' => 'TSP',
				'level' => '9'
			],
			[
				'inisial' => 'RO',
				'role_name' => 'RO',
				'level' => '9'
			],
		]);
	}
}
