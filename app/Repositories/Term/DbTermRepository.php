<?php
/**
 * Created by PhpStorm.
 * User: harryg
 * Date: 03/02/15
 * Time: 23:31
 */

namespace Creuset\Repositories\Term;


use Creuset\Term;
use Illuminate\Database\Eloquent\Model;

class DbTermRepository implements TermRepository {
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->getTerms('category');
    }

    /**
     * @param Model $relatedModel
     * @return array
     */
    public function getCategoryList(Model $relatedModel = null)
    {
        $categories = $this->getCategories()->lists('term', 'id')->toArray();

        if ( ! is_null($relatedModel) )
            $categories = $this->orderBySelected($categories, $relatedModel);

        return $categories;
    }

    /**
     * @param $taxonomy
     * @return mixed
     */
    protected function getTerms($taxonomy)
    {
        return Term::where('taxonomy', $taxonomy)->orderBy('term')->get();
    }

    /**
     * Orders the term list to put the terms currently attached to the model at the top
     *
     * @param array $terms The list of terms
     * @param Model $relatedModel The model with terms
     * @param string $termType Categories, tags etc - corresponds with the relationship name
     * @return array The reordered term list
     */
    protected function orderBySelected($terms, Model $relatedModel, $termType = 'categories')
    {
        $selectedTerms = array_pluck($relatedModel->{$termType}->toArray(), 'pivot.term_id');

        foreach ($selectedTerms as $selectedTerm)
            $terms = [$selectedTerm => $terms[$selectedTerm]] + $terms;

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
        return $this->create($term, 'tag', $slug);
    }

    public function createCategory($term, $slug = null)
    {
        return $this->create($term, 'category', $slug);
    }


    /**
     * Persist a new term to the database
     * 
     * @param  string $term     The term
     * @param  string $taxonomy The term's taxonomy
     * @param  string $slug     The slug of the term. A slug will be automatically generated if nothing passed
     * @return Term             The newly created term object
     */
    private function create($term, $taxonomy, $slug = null)
    {
        if (!$slug) $slug = str_slug($term);

        return Term::create([
            'term'  => $term,
            'taxonomy'  => $taxonomy,
            'slug'      => $slug,
        ]);
    }

    /**
     * Process an array of mixed string and numneric terms, create a new term for each string
     * 
     * @param  array $terms The terms to process
     * @param  string $as   The taxonomy of the terms in question
     * @return array        An array of the ids of terms, including the newly created ones
     */
    public function process($terms, $as = 'tag')
    {
        // extract the input into separate integer and string arrays
        $currentTerms = array_filter($terms, 'is_numeric');     // [1, 3, 5]
        $newTerms = array_diff($terms, $currentTerms);

        // Create a new tag for each string in the input and update the current tags array
        foreach ($newTerms as $newTerm)
        {
            if ($term = $this->create($newTerm, $as))
                $currentTerms[] = $term->id;
        }

        return $currentTerms;
    }
}
