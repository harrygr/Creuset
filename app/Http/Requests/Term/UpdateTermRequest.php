<?php

namespace App\Http\Requests\Term;

use App\Http\Requests\Request;

class UpdateTermRequest extends Request
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
        $term = $this->route('term');

        return [
            'term'    => 'unique:terms,term,'.$term->id.',id,taxonomy,'.$term->taxonomy, // term is only unique for a given taxonomy
            'slug'    => 'unique:terms,slug,'.$term->id.',id,taxonomy,'.$term->taxonomy,
            'order'   => 'numeric',
        ];
    }
}
