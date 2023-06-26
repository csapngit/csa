<?php

namespace Database\Seeders;

use App\Models\StoreCategory;
use Illuminate\Database\Seeder;

class StoreCategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$categories = [
			'Farmers',
			'Ranch',
			'Hari Hari',
			'Grand Lucky',
			'Diamond',
			'AEON',
			'Watson',
			'ADA Swalayan',
			'Loka',
			'Fortuna',
			'GS Retail',
			'Harmony',
			'Yan',
			'Aneka Buana',
			'Tokem',
		];

		$categories = collect($categories)->map(function ($category) {
			return [
				'name' => $category
			];
		})->all();

		StoreCategory::insert($categories);
	}
}
