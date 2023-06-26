<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'barcode' => $this->barcode,
			'category_id' => $this->category_id,
			'category' => $this->category->only('id', 'name'),
			'brand' => $this->brand,
			'serial_number' => $this->serial_number,
			'year' => $this->year,
			'name' => $this->name,
			'division' => $this->division,
			'branch_id' => $this->branch_id,
			'branch' => $this->branch->only('id', 'BranchName'),
			'lend_date' => $this->lend_date,
			'return_date' => $this->return_date,
			'description' => $this->description,
		];
	}
}
