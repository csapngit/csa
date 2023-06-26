<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterBranchSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('master_branches')->insert([
			['Area' => 'CSAJ', 'Branch' => 'HO', 'BranchName' => 'HEAD OFFICE', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'HT', 'BranchName' => 'CENGKARENG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'DT', 'BranchName' => 'BOGOR', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'GT', 'BranchName' => 'SERANG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'CT', 'BranchName' => 'BANJAR', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'ET', 'BranchName' => 'DEPOK', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'FT', 'BranchName' => 'CONDET', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'BT', 'BranchName' => 'KEBAYORAN', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'JT', 'BranchName' => 'TANGSEL', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'PT', 'BranchName' => 'PANDEGLANG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAJ', 'Branch' => 'LT', 'BranchName' => 'TSP', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'A2', 'BranchName' => 'PALEMBANG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'A1', 'BranchName' => 'LINGGAU', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'A3', 'BranchName' => 'PRABUMULIH', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'A4', 'BranchName' => 'BATURAJA', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'B1', 'BranchName' => 'LAMPUNG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'B2', 'BranchName' => 'METRO', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'B3', 'BranchName' => 'PRINGSEWU', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'B4', 'BranchName' => 'KOTABUMI', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'C1', 'BranchName' => 'BUNGO', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'C2', 'BranchName' => 'BENGKULU', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'D1', 'BranchName' => 'JAMBI', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'E1', 'BranchName' => 'BELITUNG', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
			['Area' => 'CSAS', 'Branch' => 'E2', 'BranchName' => 'BANGKA', 'BranchAddress' => '-', 'CreatedBy' => 1, 'created_at' => Carbon::now()],
		]);
	}
}
