<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStore extends Model
{
	use HasFactory;

	protected $fillable = [
		'store_id',
		'name',
	];

	public function storeCategory()
	{
		return $this->belongsTo(StoreCategory::class, 'store_id');
	}
}
