<?php

namespace App\Http\Requests;

use App\Enums\ProgramTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
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
		$rules = [
			'area' => 'required',
			'name' => 'required',
			'program_type_id' => 'required',
			'program_display_type_id' => 'required|exists:program_display_types,id',
			'master_brand_id' => 'required|exists:master_brands,id',
			'sku_group_id' => 'required|exists:sku_groups,id',
			'inventoryIds' => 'required',
			'valid_from' => 'required',
			'valid_until' => 'required',
			'promo' => 'required',
			'depth' => 'required',
			'cut_price' => 'required',
		];

		if (request()->program_display_type_id != ProgramTypeEnum::DISPLAY) {
			unset($rules['program_display_type_id']);
		}

		return $rules;
	}

	public function attributes()
	{
		return [
			'area' => __('app.programs.area'),
			'name' => __('app.programs.name'),
			'program_type_id' => __('app.programs.program_type_id'),
			'sku_group_id' => __('app.programs.sku_group'),
			'inventoryIds' => __('app.programs.inventory'),
			'valid_from' => __('app.tables.date'),
			'valid_until' => __('app.tables.date'),
		];
	}
}
