<?php

namespace Unit;

use App\Repositories\Post\DbPostRepository;
use TestCase;

class PostsTest extends TestCase
{
    protected $posts;

    public function setUp()
    {
        parent::setUp();
        $this->posts = new DbPostRepository(new \App\Post());
    }

    public function testHomePageWorks()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetPostsForUser()
    {
        $user = factory('App\User')->create();

        factory('App\Post', 2)->create(['user_id' => $user->id]);
        factory('App\Post', 3)->create();

        $posts = $this->posts->getByUserId($user->id);
        $this->assertCount(2, $posts);
    }

    public function testGetSinglePosts()
    {
        $postDummy = factory('App\Post')->create();

        $post = $this->posts->fetch($postDummy->id);
        $this->assertEquals($post->slug, $postDummy->slug);

        $postDummy = factory('App\Post')->create();
        $post = $this->posts->getBySlug($postDummy->slug);
        $this->assertEquals($post->slug, $postDummy->slug);
    }
}
