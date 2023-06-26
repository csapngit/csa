<?php

namespace Database\Seeders;

use App\Models\IncentiveType;
use Illuminate\Database\Seeder;

class IncentiveTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $incentiveTypes = [
      [
        'name' => 'percentage',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => 'nominal',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    IncentiveType::insert($incentiveTypes);
  }
}
