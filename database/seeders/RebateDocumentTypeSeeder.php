<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RebateDocumentTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('rebate_document_types')->insert([
      ['notes' => '-', 'created_at' => Carbon::now(),  'name' => 'Invoice'],
      ['notes' => '-', 'created_at' => Carbon::now(),  'name' => 'Kontrak Golden'],
      ['notes' => '-', 'created_at' => Carbon::now(),  'name' => 'NPWP'],
      ['notes' => '-', 'created_at' => Carbon::now(),  'name' => 'KTP'],
    ]);
  }
}
