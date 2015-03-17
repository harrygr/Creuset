<?php namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;

class CreateTermRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'term'	=> 'required|unique:terms,name'
		];
	}

}
