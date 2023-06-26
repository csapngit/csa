<?php

namespace Database\Seeders;

use App\Enums\ProgramTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // DB::table('programs')->insert([
    //   [
    //     'area'        => 'CSAJ',
    //     'name'        => 'Golden Program Jakarta',
    //     'type_id'     => ProgramTypeEnum::REGULAR,
    //     'is_active'   => 1,
    //     'valid_from'  => Carbon::parse('2022-07-01'),
    //     'valid_until' => Carbon::parse('2022-12-01'),
    //     'created_at'  => now(),
    //     'updated_at'  => now(),
    //   ],
    //   [
    //     'area'        => 'CSAS',
    //     'name'        => 'Golden Program Sumatra',
    //     'type_id'     => 1,
    //     'is_active'   => 1,
    //     'valid_from'  => Carbon::parse('2022-07-01'),
    //     'valid_until' => Carbon::parse('2022-12-01'),
    //     'created_at'  => now(),
    //     'updated_at'  => now(),
    //   ],
    // ]);
  }
}
