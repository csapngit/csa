<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Tax::query()->create([
      'display_pkp'     => 2,
      'display_non_pkp' => 4,
      'volume_pkp'      => 2.5,
      'volume_non_pkp'  => 3,
      'company'         => 15,
    ]);
  }
}
