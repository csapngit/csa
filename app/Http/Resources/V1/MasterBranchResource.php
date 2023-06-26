<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterBranchResource extends JsonResource
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
			'DistributorCode' => $this->DistributorCode,
			'BranchCode' => $this->BranchCode,
			'BranchName' => $this->BranchName,
			'AreaCode' => $this->AreaCode,
			'AreaName' => $this->AreaName,
			'Address' => $this->Address,
			'Region' => $this->Region,
			'Phone' => $this->Phone,
			'Lat' => $this->Lat,
			'Long' => $this->Long,
			'Flag' => $this->Flag,
		];
	}
}
