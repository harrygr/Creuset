<?php

namespace App\Http\Controllers\Api;

use App\Term;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;

class TermsControllerTest extends \TestCase
{
    use DatabaseTransactions;

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->logInAsAdmin();
    }

    /** @test **/
    public function it_saves_a_new_term_in_the_database()
    {
        $payload = [
            'term'     => 'pa laa',
            'taxonomy' => 'product_category',
        ];

        $this->json('POST', 'api/terms', $payload)->seeJson(['term' => 'pa laa']);

        $this->seeInDatabase('terms', $payload);
    }

    /** @test **/
    public function it_sanitizes_taxonomies()
    {
        $payload = [
            'term'     => 'Very Tall',
            'taxonomy' => 'Tree Height',
        ];

        $this->json('POST', 'api/terms', $payload)->seeJson(['term' => 'Very Tall']);

        $this->seeInDataBase('terms', ['taxonomy' => 'tree_height', 'term' => 'Very Tall']);
    }

    /** @test **/
    public function it_gets_terms()
    {
        $terms = factory(Term::class, 5)->create(['taxonomy' => 'product_category']);

        $this->json('GET', route('api.terms', 'product_category'))->seeJson(['term' => $terms[0]->term]);
    }

    /** @test **/
    public function it_does_not_allow_saving_duplicate_terms_of_a_certain_taxonomy()
    {
        $payload = [
            'term'     => 'Humungous',
            'taxonomy' => 'Lampshade Size',
        ];
        $this->json('POST', 'api/terms', $payload);
        $this->assertResponseOk();

        // adjust the taxonomy to just send the snake case version
        $payload = [
            'term'     => 'humungous',
            'taxonomy' => 'lampshade_size',
        ];

        $this->json('POST', 'api/terms', $payload);

        $this->seeJson(['The term has already been taken.']);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test **/
    public function it_deletes_a_term_from_storage()
    {
        $term = factory(Term::class)->create();

        $this->json('DELETE', "api/terms/{$term->id}");

        $this->notSeeInDatabase('terms', ['taxonomy' => $term->taxonomy, 'term' => $term->term]);
    }

    /** @test */
    public function it_updates_a_term()
    {
        $term = factory(Term::class)->create();

        $this->json('PATCH', "api/terms/{$term->id}", ['order' => 11]);

        $this->seeInDatabase('terms', ['taxonomy' => $term->taxonomy, 'term' => $term->term, 'order' => 11]);
    }
}
