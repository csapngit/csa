<?php

namespace Database\Seeders;

use App\Models\ProgramType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$types = [
			[
				'name'       => 'Regular',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'Sessional',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'Display',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'KBD1',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'KBD2',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'IGNITE',
				'created_at' => now(),
				'updated_at' => now(),
			],
			[
				'name'       => 'Additional',
				'created_at' => now(),
				'updated_at' => now(),
			],
		];

		ProgramType::insert($types);
	}
}
