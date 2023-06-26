<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RebateStatusTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('rebate_status_types')->insert([
      ['status' => 'New',             'descr' => '-',   'pic' => 'CSA',   'style' => "label-primary label-inline font-weight-bolder mr-2"],
      ['status' => 'Invalid',         'descr' => '-',   'pic' => 'PG',    'style' => "label-primary label-inline font-weight-bolder mr-2"],
      ['status' => 'Paid',            'descr' => '-',   'pic' => 'PG',    'style' => "label-primary label-inline font-weight-bolder mr-2"],
      ['status' => 'Incomplete Data', 'descr' => '-',   'pic' => 'CSA',   'style' => "label-primary label-inline font-weight-bolder mr-2"],
    ]);
  }
}
