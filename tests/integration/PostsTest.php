<?php

namespace Unit;

use Creuset\Repositories\Post\DbPostRepository;
use TestCase;

class PostsTest extends TestCase
{
    protected $posts;

    public function setUp()
    {
        parent::setUp();
        $this->posts = new DbPostRepository(new \Creuset\Post());
    }

    public function testHomePageWorks()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetPostsForUser()
    {
        $user = factory('Creuset\User')->create();

        factory('Creuset\Post', 2)->create(['user_id' => $user->id]);
        factory('Creuset\Post', 3)->create();

        $posts = $this->posts->getByUserId($user->id);
        $this->assertCount(2, $posts);
    }

    public function testGetSinglePosts()
    {
        $postDummy = factory('Creuset\Post')->create();

        $post = $this->posts->fetch($postDummy->id);
        $this->assertEquals($post->slug, $postDummy->slug);

        $postDummy = factory('Creuset\Post')->create();
        $post = $this->posts->getBySlug($postDummy->slug);
        $this->assertEquals($post->slug, $postDummy->slug);
    }
}
