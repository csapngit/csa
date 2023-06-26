<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateExportRequest extends FormRequest
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
      'area'       => 'required',
      'key_id'     => 'required',
      'program_id' => 'required',
    ];
  }

	public function attributes()
	{
		return [
			'key_id' => __('app.generates.key'),
			'area' => __('app.area.area'),
			'program_id' => __('app.programs.name'),
		];
	}
}
