<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
	use HasFactory;

	protected $fillable = [
		'reference_id',
		'reference_type',
		'action',
		'executor_id',
		'data',
		'executed_at',
	];
}
