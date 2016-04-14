<?php

namespace App\Repositories\Term;

use App\Contracts\Termable;

interface TermRepository
{
    /**
     * @param $taxonomy
     *
     * @return mixed
     */
    public function getTerms($taxonomy);

    /**
     * Get all the categories.
     *
     * @return mixed
     */
    public function getCategories();

    /**
     * Get a list of all the categories.
     *
     * @param \App\Contracts\Termable $related_model If passed will put attached categories at the top of the list
     *
     * @return mixed
     */
    public function getCategoryList(Termable $related_model);

    /**
     * Get all the tags.
     *
     * @return mixed
     */
    public function getTags();

    /**
     * Get a list of all the tags.
     *
     * @return mixed
     */
    public function getTagList();

    /**
     * Create a new Tag Term.
     *
     * @param string $term The tag name
     * @param string $slug The slug of the tag
     *
     * @return \App\Term
     */
    public function createTag($term, $slug = null);

    /**
     * Create a new Category Term.
     *
     * @param string $term The category name
     * @param string $slug The slug of the category
     *
     * @return \App\Term
     */
    public function createCategory($term, $slug = null);

    /**
     * Create new term.
     *
     * @param array $attributes
     *
     * @return \App\Term
     */
    public function create($attributes);

    /**
     * Process an array of mixed string and numneric terms, create a new term for each string.
     *
     * @param array  $terms    The terms to process
     * @param string $taxonomy The taxonomy of the terms in question
     *
     * @return array An array of the ids of terms, including the newly created ones
     */
    public function process($terms, $taxonomy = 'tag');
}
