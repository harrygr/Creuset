<?php

namespace App\Repositories\Term;

use App\Contracts\Termable;
use App\Term;
use Illuminate\Database\Eloquent\Model;

class DbTermRepository implements TermRepository
{
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->getTerms('category');
    }

    /**
     * Get a list of categories for use, say, in a checklist or multi-select.
     *
     * @param Termable $related_model If provided, categories attached to the model will be ordered at the top of the list
     *
     * @return array
     */
    public function getCategoryList(Termable $related_model = null)
    {
        $categories = $this->getCategories()->lists('term', 'id')->toArray();

        if (!is_null($related_model)) {
            $categories = $this->orderBySelected($categories, $related_model);
        }

        return $categories;
    }

    /**
     * @param $taxonomy
     *
     * @return mixed
     */
    public function getTerms($taxonomy)
    {
        return Term::where('taxonomy', $taxonomy)->orderBy('term')->get();
    }

    /**
     * Orders the term list to put the terms currently attached to the model at the top.
     *
     * @param array    $terms         The list of terms
     * @param Termable $related_model The model with terms
     * @param string   $termType      Categories, tags etc - corresponds with the relationship name
     *
     * @return array The reordered term list
     */
    protected function orderBySelected($terms, Termable $related_model, $termType = 'categories')
    {
        $selectedTerms = array_pluck($related_model->{$termType}->toArray(), 'pivot.term_id');

        foreach ($selectedTerms as $selectedTerm) {
            $terms = [$selectedTerm => $terms[$selectedTerm]] + $terms;
        }

        return $terms;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->getTerms('tag');
    }

    /**
     * @return array
     */
    public function getTagList()
    {
        return $this->getTags()->lists('term', 'id');
    }

    public function createTag($term, $slug = null)
    {
        $taxonomy = 'tag';

        return $this->create(compact('term', 'slug', 'taxonomy'));
    }

    public function createCategory($term, $slug = null)
    {
        $taxonomy = 'category';

        return $this->create(compact('term', 'slug', 'taxonomy'));
    }

    /**
     * Persist a new term to the database.
     *
     * @param string $term     The term
     * @param string $taxonomy The term's taxonomy
     * @param string $slug     The slug of the term. A slug will be automatically generated if nothing passed
     *
     * @return Term The newly created term object
     */
    public function create($attributes)
    {
        return Term::create($attributes);
    }

    /**
     * Process an array of mixed string and numneric terms, create a new term for each string.
     *
     * @param array  $terms    The terms to process
     * @param string $taxonomy The taxonomy of the terms in question
     *
     * @return array An array of the ids of terms, including the newly created ones
     */
    public function process($terms, $taxonomy = 'tag')
    {
        // extract the input into separate integer and string arrays
        $currentTerms = array_filter($terms, 'is_numeric');     // [1, 3, 5]
        $newTerms = array_diff($terms, $currentTerms);

        // Create a new tag for each string in the input and update the current tags array
        foreach ($newTerms as $newTerm) {
            if ($term = $this->create(['term' => $newTerm, 'taxonomy' => $taxonomy])) {
                $currentTerms[] = $term->id;
            }
        }

        return $currentTerms;
    }
}
