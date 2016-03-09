<?php

namespace App\Http\Requests;

class CreateTermRequest extends Request
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
        // If no category in the request we assume it's a category as that's the db default
        $taxonomy = $this->input('taxonomy', 'category');

        return [
            'term'    => 'required|unique:terms,term,NULL,id,taxonomy,'.$taxonomy, // term is only unique for a given taxonomy
            'slug'    => 'required|unique:terms,slug,NULL,id,taxonomy,'.$taxonomy,
            'order'   => 'integer',
        ];
    }

    /**
     * Override the all method to sanitize input first.
     *
     * @return array
     */
    public function all()
    {
        $this->sanitize();

        return parent::all();
    }

    /**
     * Sanitize the input to ensure we have a slug and things are in snake case.
     *
     * @return void
     */
    public function sanitize()
    {
        $taxonomy = snake_case($this->input('taxonomy'));

        $slug = $this->input('slug', str_slug($this->input('term')));

        $this->merge(['taxonomy' => $taxonomy, 'slug' => $slug]);
    }

    /**
     * Customize the messages that are related to unique terms.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'term.unique'      => 'The term has already been taken.',
            'slug.unique'      => 'The term has already been taken.',
            ];
    }
}
