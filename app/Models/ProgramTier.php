<?php

namespace App\Models;

use App\Enums\IncentiveTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTier extends Model
{
  use HasFactory;

  protected $fillable = [
    'program_id',
    'incentive_type_id',
    'name',
    'display',
    'cashback',
    'monthly_display',
    'monthly_volume',
    'minimum_purchase',
    'maximum_purchase',
		'minimum_pcs',
    'maximum_pcs',
    'voucher_type_id',
  ];

  public function program()
  {
    return $this->belongsTo(Program::class);
  }

  public function incentiveType()
  {
    return $this->belongsTo(IncentiveType::class);
  }

  public function voucherType()
  {
    return $this->belongsTo(VoucherType::class);
  }

  public function getFormattedMonthlyDisplayAttribute()
  {
    if ($this->incentive_type_id == IncentiveTypeEnum::PERCENTAGE) {
      return $this->monthly_display . __('app.operators.percentage');
    }

    return __('app.operators.rupiah') . ' ' . number_format($this->monthly_display, 2);
  }

  public function getFormattedCashbackAttribute()
  {
    if ($this->incentive_type_id == IncentiveTypeEnum::PERCENTAGE) {
      return $this->cashback . __('app.operators.percentage');
    }

    return __('app.operators.rupiah') . ' ' . number_format($this->cashback, 2);
  }
}
