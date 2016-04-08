<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\Request;
use App\Repositories\Term\TermRepository;

class PageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We'll allow users to edit each other's posts for now
        // Maybe add some role-based authorization at some point
        return true;
    }
}
