<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetTrackingPayment extends Model
{
	use HasFactory;

	protected $fillable = [
		'area',
		'branch',
		'segment',
		'target',
	];
}
