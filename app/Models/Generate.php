<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{
  use HasFactory;

  protected $fillable = [
    'area',
    'key_id',
    'program_id',
    'master_branch_id',
    'customer_id',
    'name',
    'sales_person',
    'target',
    'offtakes',
    'is_active_display',
    'incentive_display',
    'incentive_volume',
    'pkp',
    'tax_display_pkp',
    'tax_display_non_pkp',
    'tax_volume_pkp',
    'tax_volume_non_pkp',
    'is_company',
    'tax_company',
    'description',
    'qty_pcs',
    'qty_carton',
    'voucher_publish',
    'shipperid',
    'invcnbr',
    'TotInvc',
    'printed',
    'start_date',
    'end_date',
  ];

  public function program()
  {
    return $this->belongsTo(Program::class);
  }

  public function key()
  {
    return $this->belongsTo(Key::class);
  }

  public function masterBranchId()
  {
    return $this->belongsTo(MasterBranch::class);
  }
}
