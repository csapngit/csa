<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetServiceRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'asset_id' => 'required',
			'service_date' => 'required',
			'description' => 'required',
		];
	}

	public function attributes()
	{
		return [
			'asset_id' => __('app.services.asset_id')
		];
	}
}
