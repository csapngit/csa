<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramImageRequest extends FormRequest
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
			'program_id' => 'required',
			'customer_id' => 'required',
			'inventory_id' => 'required',
			'normal_price' => 'required',
			'promo_price' => 'required',
			'image' => 'required|file|mimes:png,jpg,jpeg'
		];
	}
}
