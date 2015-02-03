<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\DatabaseTransactions;

use Laracasts\Behat\Context\Migrator;
use Laracasts\TestDummy\Factory;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

    use Migrator, DatabaseTransactions, AuthenticationFeature;


    protected $postId;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I create a post :title :content
     * @param $title string
     * @param $content string
     */
    public function iCreateAPost($title, $content)
    {
        $this->visit('admin/posts/create');
        $this->fillField('title', $title);
        $this->fillField('slug', Str::slug($title));
        $this->fillField('content', $content);
        $this->pressButton('Create Post');

    }

    /**
     * @Then I should see a post :title
     * @param $title
     */
    public function iShouldSeeAPost($title)
    {
        $this->assertPageContainsText($title);
    }

    /**
     * @When I view the list of posts
     */
    public function iViewTheListOfPosts()
    {
        $this->visit('admin/posts');
    }

    /**
     * @Given I have a post :title :content
     * @param $title
     * @param $content
     */
    public function iHaveAPost($title, $content)
    {
        $postDummy = Factory::create('Creuset\Post', ['title' => $title, 'content' => $content, 'user_id' => Auth::id()]);
        $this->postId = $postDummy->id;
    }

    /**
     * @When I edit a post :title
     * @param $title
     */
    public function iEditAPost($title)
    {
        $this->visit('admin/posts/' . $this->postId . '/edit');
        $this->fillField('title', $title);
        $this->pressButton('Update');
    }
}
