<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetService extends Model
{
	use HasFactory;

	protected $dates = [
		'service_date',
		'return_date',
	];

	protected $fillable = [
		'asset_id',
		'service_date',
		'description',
		'return_date',
	];

	public function asset()
	{
		return $this->belongsTo(Asset::class, 'asset_id');
	}
}
