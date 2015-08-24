<?php namespace Unit;

use TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Creuset\Repositories\Term\TermRepository;

class TermsTest extends TestCase 
{

	use DatabaseTransactions;

	public function testICanDeleteATerm()
	{
		$this->withoutMiddleware();

		$category = factory('Creuset\Term')->create([
		  'taxonomy' => 'category',
		  'term' => 'nasty cat'
		  ]);

		$this->seeInDatabase('terms', ['term' => 'nasty cat', 'taxonomy' => 'category']);

		$response = $this->action('DELETE', 'Admin\TermsController@destroy', ['term' => $category]);

		$this->assertRedirectedTo('/admin/categories');
		$this->notSeeInDatabase('terms', ['term' => 'nasty cat', 'taxonomy' => 'category']);
	}

	public function testItCanProcessNewTerms()
	{
		// Start with some tags in the database
		$tags = factory('Creuset\Term', 3)->create([
			'taxonomy' => 'tag'
			]);

		// Combine their IDs with strings of tags for new creation
		$tags = collect(["Smashing", "Wonderful Thoughts"])->merge($tags->pluck('id'));

		$termRepo = app()->make(TermRepository::class);

		// Process the tags
		$tagIds = $termRepo->process($tags->toArray(), 'tag');
		
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
