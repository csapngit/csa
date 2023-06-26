<?php

namespace Database\Seeders;

use App\Models\ProgramDisplayType;
use Illuminate\Database\Seeder;

class ProgramDisplayTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$displayTypes = [
			'End Gondola',
			'Floor Display',
			'Stande',
			'Clipstrip',
			'Top Row',
			'Rak Reguler',
			'COC',
		];

		$displayTypes = collect($displayTypes)->map(function($displayType) {
			return [
				'name' => $displayType,
				'created_at' => now(),
				'updated_at' => now(),
			];
		})->all();

		ProgramDisplayType::insert($displayTypes);
	}
}
