<?php

namespace Creuset\Http\Requests;

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
        $taxonomy = $this->get('taxonomy', 'category');

        return [
            'term'    => 'required|unique:terms,term,NULL,id,taxonomy,'.$taxonomy, // term is only unique for a given taxonomy
        ];
    }
}
