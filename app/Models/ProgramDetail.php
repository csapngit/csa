<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDetail extends Model
{
	use HasFactory;

	protected $fillable = [
		'program_id',
		'master_brand_id',
		'program_display_type_id',
		'sku_group_id',
		'promo',
		'depth',
		'cut_price',
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}

	public function master_brand()
	{
		return $this->belongsTo(MasterBrand::class)->withDefault();
	}

	public function program_display_type()
	{
		return $this->belongsTo(ProgramDisplayType::class)->withDefault();
	}

	public function sku_group()
	{
		return $this->belongsTo(SkuGroup::class)->withDefault();
	}
}
