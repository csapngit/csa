<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
			'category_id' => 'required',
			'brand' => 'required',
			'serial_number' => 'required',
			'purchase_date' => 'required',
			'name' => 'required',
			'division_id' => 'required',
			'branch_id' => 'required',
			'branch_id' => 'required',
			'lend_date' => 'required',
		];
	}

	public function attributes()
	{
		return [
			'category_id' => __('app.assets.category_id'),
			'division_id' => __('app.assets.division_id'),
			'branch_id' => __('app.assets.branch_id'),
		];
	}
}
