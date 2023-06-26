<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramImage extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'program_id',
		'customer_id',
		'inventory_id',
		'normal_price',
		'promo_price',
		'depth',
		'text',
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}

	public function master_customers()
	{
		return $this->hasMany(MasterCustomer::class, 'CustID', 'customer_id');
	}

	public function master_inventories()
	{
		return $this->hasMany(MasterInventory::class, 'InvtID', 'inventory_id');
	}

	public function getFormattedNormalPriceAttribute()
	{
		return __('app.operators.rupiah') . number_format($this->normal_price);
	}

	public function getFormattedPromoPriceAttribute()
	{
		return __('app.operators.rupiah') . number_format($this->promo_price);
	}
}
