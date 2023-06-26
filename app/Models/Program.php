<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
  use HasFactory;

  protected $dates = [
    'valid_from',
    'valid_until',
  ];

  protected $fillable = [
    'area',
    'is_active',
    'name',
    'program_type_id',
    'valid_from',
    'valid_until',
  ];

	public function masterInventories()
	{
		return $this->belongsToMany(MasterInventory::class, 'program_has_product', 'program_id', 'inventory_id');
	}

  public function program_type()
  {
    return $this->belongsTo(ProgramType::class);
  }

  public function programTiers()
  {
    return $this->hasMany(ProgramTier::class);
  }

  public function customers()
  {
    return $this->hasMany(Customer::class);
  }

	public function program_detail()
	{
		return $this->hasOne(ProgramDetail::class);
	}
}
