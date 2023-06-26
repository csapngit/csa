<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'status_active',
    'status_um',
    'status_rm',
  ];
}
