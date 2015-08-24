<?php namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;
use Illuminate\Support\Facades\Log;

class CreatePostRequest extends PostRequest {

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
		$this->sanitize();

		return [
			'title'	=> 'required',
			'slug'	=> 'required|unique:posts,slug',
			'published_at' => 'required|date',
		];
	}

}
