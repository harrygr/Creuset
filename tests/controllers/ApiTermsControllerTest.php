<?php


use Creuset\Term;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;

class ApiTermsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_saves_a_new_term_in_the_database()
    {
        $this->withoutMiddleware();
        $payload = [
            'term'     => 'pa laa',
            'taxonomy' => 'product_category',
        ];

        $this->post('api/terms', $payload)->seeJson(['term' => 'pa laa']);

        $this->seeInDataBase('terms', $payload);
    }

    /** @test **/
    public function it_gets_terms()
    {
        $terms = factory(Term::class, 5)->create(['taxonomy' => 'product_category']);

        $this->get(route('api.terms', 'product_category'))->seeJson(['term' => $terms[0]->term]);
    }

    /* @test **/
    // public function it_does_not_allow_saving_duplicate_terms_of_a_certain_taxonomy()
    // {
    // 	$this->withoutMiddleware();
    // 	$payload = [
    // 		'term' => 'pa laa',
    // 		'slug' => 'pa-laa',
    // 		'taxonomy' => 'product_category'
    // 	];
    // 	$this->post('api/terms', $payload);
    // 	$this->assertResponseOk();

    // 	$this->post('api/terms', $payload);
    // 	var_dump($this->response->getContent());
    // 	$this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    // }
}
