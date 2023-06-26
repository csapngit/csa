<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
	use HasFactory, SoftDeletes;

	protected $dates = [
		'lend_date',
		'return_date',
		'purchase_date'
	];

	protected $fillable = [
		'barcode',
		'category_id',
		'brand',
		'serial_number',
		'purchase_date',
		'name',
		'division_id',
		'branch_id',
		'lend_date',
		'return_date',
		'description',
		'created_by',
	];

	public function category()
	{
		return $this->belongsTo(AssetCategory::class, 'category_id');
	}

	public function division()
	{
		return $this->belongsTo(Division::class);
	}

	public function branch()
	{
		return $this->belongsTo(MasterBranch::class, 'branch_id');
	}

	public function services()
	{
		return $this->hasMany(AssetService::class, 'asset_id');
	}
}
