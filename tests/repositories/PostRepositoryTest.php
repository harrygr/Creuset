<?php

namespace App\Repositories\Post;

use TestCase;

class PostRepositoryTest extends TestCase
{
    /** @test **/
    public function it_gets_posts()
    {
        $post = factory(\App\Post::class)->create();

        $category = factory(\App\Term::class)->create();

        $post->terms()->attach($category);

        $post_repository = \App::make(PostRepository::class);

        $this->assertArrayHasKey('terms', $post_repository->fetch($post->id, ['terms'])->toArray());
        $this->assertArrayNotHasKey('terms', $post_repository->fetch($post->id)->toArray());
    }
}
