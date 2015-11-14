<?php namespace Unit;

use Creuset\Repositories\Term\DbTermRepository;
use Creuset\Repositories\Term\TermRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class DbTermRepositoryTest extends TestCase 
{
	use DatabaseTransactions;

	private $terms;

	public function setUp()
	{
		parent::setUp();
		$this->terms = new DbTermRepository;
	}

	/** @test **/
	public function it_saves_a_term()
	{
		$term = [
			'term' => 'foo bar',
			'taxonomy' => 'product_category',
		];

		$this->terms->create($term);

		$this->seeInDataBase('terms', $term);
	}

	/** @test **/
	public function it_saves_a_category()
	{
		$this->terms->createCategory('baz bar');

		$this->seeInDataBase('terms', ['term' => 'baz bar', 'taxonomy' => 'category']);
	}

	/** @test **/
	public function it_saves_a_tag()
	{
		$this->terms->createTag('blah too');

		$this->seeInDataBase('terms', ['term' => 'blah too', 'taxonomy' => 'tag']);
	}

	/** @test **/
	public function it_process_new_terms()
	{
		// Start with some tags in the database
		$tags = factory('Creuset\Term', 3)->create([
			'taxonomy' => 'tag'
			]);

		// Combine their IDs with strings of tags for new creation
		$tags = collect(["Smashing", "Wonderful Thoughts"])->merge($tags->pluck('id'));

		// Process the tags
		$tagIds = $this->terms->process($tags->toArray(), 'tag');
		
		// Check the new tags are in the database
		$this->seeInDatabase('terms', [
			'term' => "Smashing",
			'taxonomy' => 'tag'
			]);

		$this->seeInDatabase('terms', [
			'slug' => "wonderful-thoughts",
			'taxonomy' => 'tag'
			]);

		// ..and the array returned contains their IDs. 
		// I.e no longer the strings
		$this->assertContainsOnly('integer', $tagIds);
	}
}