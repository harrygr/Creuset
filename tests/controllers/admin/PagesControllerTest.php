<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\UploadedFile;

class PagesControllerTest extends \TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->logInAsAdmin();
    }

    /** @test **/
    public function it_can_create_a_page()
    {
        // I go to the create pages page
        $pageTitle = 'Awesome page Title';

        $this->visit('/admin/pages/create');

        $this->post('admin/pages', [
            'title'        => $pageTitle,
            'slug'         => str_slug($pageTitle),
            'content'      => $pageContent,
            'published_at' => Carbon::now(),
            'user_id'      => $this->user->id,
            '_token'       => csrf_token(),
            ]);
        // And see that I created a post successfully
        $this->seeInDatabase('pages', [
            'content' => $pageContent,
            'user_id' => $this->user->id,
            ]);
    }

    /** @test **/
    public function it_can_edit_a_page()
    {

        // And a post exists in the database
        $page = factory('App\Page')->create();

        // I update the post
        $pageTitle = 'Edited Title';

        $this->visit("/admin/pages/{$page->id}/edit")
             ->see('Edit Page');

        $this->patch("admin/pages/{$page->id}", [
            'title'  => $pageTitle,
            'slug'   => str_slug($pageTitle),
            '_token' => csrf_token(),
            ]);

        // And see that I edited the post successfully
        $this->seeInDatabase('pages', [
            'id'      => $page->id,
            'title'   => $pageTitle,
            ]);
    }

    /** @test **/
    public function it_trashes_a_page()
    {
        $page = factory('App\Page')->create();

        $this->visit('/admin/pages')
             ->see($page->title);

        // move to trash
        $this->delete("/admin/pages/{$page->id}");
    }

    /** @test **/
    public function it_permanently_deletes_a_page()
    {
        $page = factory('App\Page')->create([
            'deleted_at' => Carbon::now()->subDay(),
        ]);

        $this->visit('/admin/pages')
              ->dontSee($page->title);

        $this->visit('admin/pages/trash')
             ->see($page->title);

        // Delete permanently
        $this->delete("/admin/pages/{$page->id}");

        $this->notSeeInDatabase('pages', [
            'title' => $page->title,
            ]);
    }

    /** @test **/
    public function it_restores_a_page()
    {
        $page = factory('App\Page')->create();

        // move to trash
        $this->delete("/admin/pages/{$page->id}");
        // restore
        $this->put("/admin/pages/{$page->id}/restore");

        $this->visit('/admin/pages')
             ->see($page->title);
    }

}
