<?php

namespace App\Http\Requests\Term;

use App\Http\Requests\Request;

class CreateManyTermsRequest extends Request
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
        $this->sanitize();

        $taxonomy = array_get($this->all(), 'taxonomy');

        return [
            'taxonomy'      => 'required',
            'terms.*.term'  => 'required|unique:terms,term,NULL,id,taxonomy,'.$taxonomy, // term is only unique for a given taxonomy
            'terms.*.slug'  => 'required|unique:terms,slug,NULL,id,taxonomy,'.$taxonomy, // slug is only unique for a given taxonomy
            ];
    }

    public function messages()
    {
        return [
            'taxonomy.required'      => 'Please provide an attribute name.',
            'terms.*.slug.unique'    => 'The property ":attribute" already exists',
            ];
    }

    public function sanitize()
    {
        $taxonomy = snake_case($this->get('taxonomy'));

        $terms = array_map(function ($term) use ($taxonomy) {

            $term['taxonomy'] = $taxonomy;
            $term['slug'] = str_slug(array_get($term, 'term'));

            return $term;
        }, $this->get('terms'));

        $this->replace(['terms' => $terms, 'taxonomy' => $taxonomy]);

        return $this->all();
    }
}
