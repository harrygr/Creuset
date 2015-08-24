<?php

namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;
use Creuset\Repositories\Term\TermRepository;

class PostRequest extends Request
{
    protected $terms;

    public function __construct(TermRepository $terms)
    {
        parent::__construct();
        $this->terms = $terms;
    }

   /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize()
    {
        $attributes = $this->all();

        if (isset($attributes['terms']))
        {
            $attributes['terms'] = $this->terms->process($attributes['terms']);
            $this->replace($attributes);
        }

        return $this->all();
    }

}
