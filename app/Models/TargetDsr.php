<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetDsr extends Model
{
	use HasFactory;

	protected $fillable = [
		'area',
		'branch',
		'mapping',
		'target_sales',
	];
}
