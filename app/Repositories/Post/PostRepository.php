<?php

namespace App\Repositories\Post;

interface PostRepository
{
    /**
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    public function fetch($id, $with = []);

    /**
     * @param array $with
     *
     * @return mixed
     */
    public function getPaginated($with = []);

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);

    public function count();

    public function trashedCount();
}
