<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
  use HasFactory;

  protected $fillable = [
    'key_id',
    'attachment_um',
    'attachment_rm',
  ];

  public function key()
  {
    return $this->belongsTo(Key::class);
  }
}
