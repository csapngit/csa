<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('master_areas')->insert([
        ['inisial' => 'CSAJ', 'area_name' => 'CSA. Jakarta',  'created_at' => Carbon::now()],
        ['inisial' => 'CSAS', 'area_name' => 'CSA. Sumatera', 'created_at' => Carbon::now()],
    ]);
}
}
