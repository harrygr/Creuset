<?php namespace Creuset\Http\Requests;

# use Creuset\Http\Requests\Request;

class UpdatePostRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	public function forbiddenResponse()
	{
		return $this->redirector->back()
		->with('alert-class', 'danger')
		->with('alert', 'You are not allowed to edit this post');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		\Log::debug('We are getting the post validation rules');
		return [
			'title'	=> 'required',
			'slug'	=> 'required|unique:posts,slug,' . $this->route('post')->id,
			'published_at' => 'required|date',
		];
	}

	/**
	 * Get the sanitized input for the request.
	 *
	 * @return array
	 */
	public function sanitize()
	{
		return $this->all();
	}

}
