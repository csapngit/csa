<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherPublishRequest extends FormRequest
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
      'start_date' => 'required',
      'end_date'   => 'required',
    ];
  }

	public function attributes()
	{
		return [
			'start_date' => __('app.tables.date'),
			'end_date' => __('app.tables.date'),
		];
	}
}
