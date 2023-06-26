<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterChannelResource extends JsonResource
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
			'LocalChannelCode' => $this->LocalChannelCode,
			'LocalChannelName' => $this->LocalChannelName,
			'SubChannelCode' => $this->SubChannelCode,
			'SubChannelName' => $this->SubChannelName,
			'GlobalChannelCode' => $this->GlobalChannelCode,
			'GlobalChannelName' => $this->GlobalChannelName,
			'Flag' => $this->Flag,
		];
	}
}
