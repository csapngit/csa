<?php

namespace Database\Seeders;

use App\Models\VoucherType;
use Illuminate\Database\Seeder;

class VoucherTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $voucherTypes = [
      [
        'name'       => 'Invoice',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name'       => 'Voucher',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    VoucherType::insert($voucherTypes);
  }
}
