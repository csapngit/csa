<?php

namespace Database\Seeders;

use App\Models\DsrWorkday;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();
		$this->call([
			UserSeeder::class,
			StoreCategorySeeder::class,
			MasterStoreSeeder::class,
			MasterAreaSeeder::class,
			MasterBranchSeeder::class,
			MasterOrderTypeSeeder::class,
			MasterBrandSeeder::class,
			SkuGroupSeeder::class,
			AppMenuSeeder::class,
			AppAutorisasiSeeder::class,
			DivisionSeeder::class,
			UserRoleSeeder::class,
			ProgramTypeSeeder::class,
			IncentiveTypeSeeder::class,
			VoucherTypeSeeder::class,
			ProgramSeeder::class,
			ProgramTierSeeder::class,
			TaxSeeder::class,
			RebateStatusTypeSeeder::class,
			SyncReportSeeder::class,
			DsrWorkday::class,
			EmailSeeder::class,
		]);
	}
}
