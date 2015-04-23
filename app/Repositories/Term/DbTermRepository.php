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
use Illuminate\Support\Str;

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


    private function create($term, $taxonomy, $slug = null)
    {
        if (!$slug) $slug = Str::slug($term);

        return Term::create([
            'term'  => $term,
            'taxonomy'  => $taxonomy,
            'slug'      => $slug,
        ]);
    }
}