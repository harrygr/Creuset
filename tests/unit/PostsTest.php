<?php namespace Unit;

use TestCase;
use DB;
use Laracasts\TestDummy\Factory as TestDummy;
use Laracasts\TestDummy\DbTestCase;
use Creuset\Repositories\Post\DbPostRepository;

class PostsTest extends TestCase {

	protected $posts;

	public function setUp()
	{
		parent::setUp();
		DB::beginTransaction();
		$this->posts = new DbPostRepository(new \Creuset\Post);
	}

	/**
	 * Rollback transactions after each test.
	 */
	public function tearDown()
	{
		DB::rollback();
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
		$user = TestDummy::create('Creuset\User');

		TestDummy::times(2)->create('Creuset\Post', ['user_id' => $user->id]);

		TestDummy::times(3)->create('Creuset\Post');

		$posts = $this->posts->getByUserId($user->id);
		$this->assertCount(2, $posts);
	}

	public function testGetSinglePosts()
	{
		$postDummy = TestDummy::create('Creuset\Post');
		$post = $this->posts->getById($postDummy->id);
		$this->assertEquals($post->slug, $postDummy->slug);

		$postDummy = TestDummy::create('Creuset\Post');
		$post = $this->posts->getBySlug($postDummy->slug);
		$this->assertEquals($post->slug, $postDummy->slug);
	}

}
