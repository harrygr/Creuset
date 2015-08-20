<?php namespace Unit;

use TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Creuset\Repositories\Post\DbPostRepository;

class PostsTest extends TestCase 
{

	use DatabaseTransactions;

	protected $posts;

	public function setUp()
	{
		parent::setUp();
		$this->posts = new DbPostRepository(new \Creuset\Post);
	}


	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
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

		$post = $this->posts->getById($postDummy->id);
		$this->assertEquals($post->slug, $postDummy->slug);

		$postDummy = factory('Creuset\Post')->create();
		$post = $this->posts->getBySlug($postDummy->slug);
		$this->assertEquals($post->slug, $postDummy->slug);
	}

}
