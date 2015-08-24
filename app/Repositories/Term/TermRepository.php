<?php namespace Creuset\Repositories\Term;



use Illuminate\Database\Eloquent\Model;

interface TermRepository {
    /**
     * Get all the categories
     *
     * @return mixed
     */
    public function getCategories();

    /**
     * Get a list of all the categories
     *
     * @param Model $relatedModel If passed will put attached categories at the top of the list
     * @return mixed
     */
    public function getCategoryList(Model $relatedModel);

    /**
     * Get all the tags
     *
     * @return mixed
     */
    public function getTags();

    /**
     * Get a list of all the tags
     *
     * @return mixed
     */
    public function getTagList();


    public function createTag($term, $slug = null);


    public function createCategory($term, $slug = null);

    /**
     * Process an array of mixed string and numneric terms, create a new term for each string
     * 
     * @param  array $terms The terms to process
     * @param  string $as   The taxonomy of the terms in question
     * @return array        An array of the ids of terms, including the newly created ones
     */
    public function process($terms, $as = 'tag');


}