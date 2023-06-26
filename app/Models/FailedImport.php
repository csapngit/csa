<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedImport extends Model
{
  use HasFactory;

  protected $dates = [
    'created_at',
    'updated_at'
  ];

  protected $fillable = [
    'customer_id',
    'batch'
  ];

  public function getSomeDateAttribute()
  {
    return $this->created_at->format('d-m-Y');
  }
}
