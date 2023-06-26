<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  use HasFactory;

  protected $fillable = [
    'program_id',
    'customer_id',
    'target',
    'program_tier_id',
  ];

  public function program()
  {
    return $this->belongsTo(Program::class);
  }

  public function programTier()
  {
    return $this->belongsTo(ProgramTier::class);
  }
}
