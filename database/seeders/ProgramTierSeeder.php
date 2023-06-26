<?php

namespace Database\Seeders;

use App\Enums\IncentiveTypeEnum;
use App\Enums\VoucherTypeEnum;
use App\Models\ProgramTier;
use Illuminate\Database\Seeder;

class ProgramTierSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // $programTiers = [
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
    //     'name'              => 'Platinum',
    //     'display'           => '0',
    //     'monthly_display'   => (float) 0,
    //     'monthly_volume'    => (float) 0,
    //     'voucher_type_id'   => VoucherTypeEnum::INVOICE,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::PERCENTAGE,
    //     'name'              => 'Diamond',
    //     'display'           => '7 + 1 Hanger',
    //     'monthly_display'   => (float) 0.5,
    //     'monthly_volume'    => (float) 0,
    //     'voucher_type_id'   => VoucherTypeEnum::INVOICE,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
    //     'name'              => 'Gold',
    //     'display'           => '7 + 1 Hanger',
    //     'monthly_display'   => (float) 150000,
    //     'monthly_volume'    => (float) 1.5,
    //     'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
    //     'name'              => 'Silver',
    //     'display'           => '5 + 1 Hanger',
    //     'monthly_display'   => (float) 50000,
    //     'monthly_volume'    => (float) 1.5,
    //     'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
    //     'name'              => 'BOS',
    //     'display'           => '5 + 1 Hanger',
    //     'monthly_display'   => (float) 50000,
    //     'monthly_volume'    => (float) 0,
    //     'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
    //   [
    //     'program_id'        => 1,
    //     'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
    //     'name'              => 'P500',
    //     'display'           => '4 Hanger',
    //     'monthly_display'   => (float) 30000,
    //     'monthly_volume'    => (float) 0,
    //     'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
    //     'created_at'        => now(),
    //     'updated_at'        => now(),
    //   ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
      //   'name'              => 'Platinum',
      //   'display'           => '0',
      //   'monthly_display'   => (float) 0,
      //   'monthly_volume'    => (float) 0,
      //   'voucher_type_id'   => VoucherTypeEnum::INVOICE,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::PERCENTAGE,
      //   'name'              => 'Diamond',
      //   'display'           => '7 + 1 Hanger',
      //   'monthly_display'   => (float) 0.5,
      //   'monthly_volume'    => (float) 0,
      //   'voucher_type_id'   => VoucherTypeEnum::INVOICE,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
      //   'name'              => 'Gold',
      //   'display'           => '7 + 1 Hanger',
      //   'monthly_display'   => (float) 150000,
      //   'monthly_volume'    => (float) 1.5,
      //   'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
      //   'name'              => 'Silver',
      //   'display'           => '5 + 1 Hanger',
      //   'monthly_display'   => (float) 50000,
      //   'monthly_volume'    => (float) 1.5,
      //   'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
      //   'name'              => 'BOS',
      //   'display'           => '5 + 1 Hanger',
      //   'monthly_display'   => (float) 50000,
      //   'monthly_volume'    => (float) 0,
      //   'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
      // [
      //   'program_id'        => 2,
      //   'incentive_type_id' => IncentiveTypeEnum::NOMINAL,
      //   'name'              => 'P500',
      //   'display'           => '4 Hanger',
      //   'monthly_display'   => (float) 30000,
      //   'monthly_volume'    => (float) 0,
      //   'voucher_type_id'   => VoucherTypeEnum::VOUCHER,
      //   'created_at'        => now(),
      //   'updated_at'        => now(),
      // ],
    // ];

    // ProgramTier::insert($programTiers);
  }
}
