<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterOrderTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('master_order_types')->insert([
      ['OrderType' => 'AT', 'BranchID' => '0', 'created_at' => Carbon::now()],
      ['OrderType' => 'BM', 'BranchID' => '7', 'created_at' => Carbon::now()],
      ['OrderType' => 'BT', 'BranchID' => '7', 'created_at' => Carbon::now()],
      ['OrderType' => 'BV', 'BranchID' => '7', 'created_at' => Carbon::now()],
      ['OrderType' => 'CN', 'BranchID' => '4', 'created_at' => Carbon::now()],
      ['OrderType' => 'CT', 'BranchID' => '4', 'created_at' => Carbon::now()],
      ['OrderType' => 'CV', 'BranchID' => '4', 'created_at' => Carbon::now()],
      ['OrderType' => 'DN', 'BranchID' => '2', 'created_at' => Carbon::now()],
      ['OrderType' => 'DT', 'BranchID' => '2', 'created_at' => Carbon::now()],
      ['OrderType' => 'DV', 'BranchID' => '2', 'created_at' => Carbon::now()],
      ['OrderType' => 'EM', 'BranchID' => '5', 'created_at' => Carbon::now()],
      ['OrderType' => 'ER', 'BranchID' => '5', 'created_at' => Carbon::now()],
      ['OrderType' => 'ET', 'BranchID' => '5', 'created_at' => Carbon::now()],
      ['OrderType' => 'EV', 'BranchID' => '5', 'created_at' => Carbon::now()],
      ['OrderType' => 'FM', 'BranchID' => '6', 'created_at' => Carbon::now()],
      ['OrderType' => 'FT', 'BranchID' => '6', 'created_at' => Carbon::now()],
      ['OrderType' => 'FV', 'BranchID' => '6', 'created_at' => Carbon::now()],
      ['OrderType' => 'GM', 'BranchID' => '3', 'created_at' => Carbon::now()],
      ['OrderType' => 'GT', 'BranchID' => '3', 'created_at' => Carbon::now()],
      ['OrderType' => 'GV', 'BranchID' => '3', 'created_at' => Carbon::now()],
      ['OrderType' => 'HM', 'BranchID' => '1', 'created_at' => Carbon::now()],
      ['OrderType' => 'HT', 'BranchID' => '1', 'created_at' => Carbon::now()],
      ['OrderType' => 'HV', 'BranchID' => '1', 'created_at' => Carbon::now()],
      ['OrderType' => 'JM', 'BranchID' => '8', 'created_at' => Carbon::now()],
      ['OrderType' => 'JT', 'BranchID' => '8', 'created_at' => Carbon::now()],
      ['OrderType' => 'JV', 'BranchID' => '8', 'created_at' => Carbon::now()],
      ['OrderType' => 'KV', 'BranchID' => '0', 'created_at' => Carbon::now()],
      ['OrderType' => 'LT', 'BranchID' => '10', 'created_at' => Carbon::now()],
      ['OrderType' => 'PM', 'BranchID' => '9', 'created_at' => Carbon::now()],
      ['OrderType' => 'PT', 'BranchID' => '9', 'created_at' => Carbon::now()],
      ['OrderType' => 'QT', 'BranchID' => '0', 'created_at' => Carbon::now()],
      ['OrderType' => 'JA', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'JE', 'BranchID' => '20', 'created_at' => Carbon::now()],
      ['OrderType' => 'MA', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'MB', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'MC', 'BranchID' => '19', 'created_at' => Carbon::now()],
      ['OrderType' => 'MD', 'BranchID' => '23', 'created_at' => Carbon::now()],
      ['OrderType' => 'ME', 'BranchID' => '20', 'created_at' => Carbon::now()],
      ['OrderType' => 'MF', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'MG', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'MH', 'BranchID' => '12', 'created_at' => Carbon::now()],
      ['OrderType' => 'MI', 'BranchID' => '19', 'created_at' => Carbon::now()],
      ['OrderType' => 'MJ', 'BranchID' => '22', 'created_at' => Carbon::now()],
      ['OrderType' => 'MK', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'MM', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'TA', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'TB', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'TC', 'BranchID' => '19', 'created_at' => Carbon::now()],
      ['OrderType' => 'TD', 'BranchID' => '23', 'created_at' => Carbon::now()],
      ['OrderType' => 'TE', 'BranchID' => '20', 'created_at' => Carbon::now()],
      ['OrderType' => 'TF', 'BranchID' => '13', 'created_at' => Carbon::now()],
      ['OrderType' => 'TG', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'TH', 'BranchID' => '12', 'created_at' => Carbon::now()],
      ['OrderType' => 'TI', 'BranchID' => '19', 'created_at' => Carbon::now()],
      ['OrderType' => 'TJ', 'BranchID' => '22', 'created_at' => Carbon::now()],
      ['OrderType' => 'TK', 'BranchID' => '16', 'created_at' => Carbon::now()],
      ['OrderType' => 'TL', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'TM', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'VA', 'BranchID' => '11', 'created_at' => Carbon::now()],
      ['OrderType' => 'VB', 'BranchID' => '15', 'created_at' => Carbon::now()],
      ['OrderType' => 'VC', 'BranchID' => '21', 'created_at' => Carbon::now()],
      ['OrderType' => 'VD', 'BranchID' => '23', 'created_at' => Carbon::now()],
      ['OrderType' => 'VE', 'BranchID' => '20', 'created_at' => Carbon::now()],
      ['OrderType' => 'VF', 'BranchID' => '13', 'created_at' => Carbon::now()],
      ['OrderType' => 'VG', 'BranchID' => '14', 'created_at' => Carbon::now()],
      ['OrderType' => 'VH', 'BranchID' => '12', 'created_at' => Carbon::now()],
      ['OrderType' => 'VI', 'BranchID' => '19', 'created_at' => Carbon::now()],
      ['OrderType' => 'VJ', 'BranchID' => '22', 'created_at' => Carbon::now()],
      ['OrderType' => 'VK', 'BranchID' => '16', 'created_at' => Carbon::now()],
      ['OrderType' => 'VL', 'BranchID' => '17', 'created_at' => Carbon::now()],
      ['OrderType' => 'VM', 'BranchID' => '18', 'created_at' => Carbon::now()],
    ]);
  }
}
