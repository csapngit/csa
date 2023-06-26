<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  use HasFactory;

  protected $fillable = [
    'display_pkp',
    'display_non_pkp',
    'volume_pkp',
    'volume_non_pkp',
    'company',
  ];
}
