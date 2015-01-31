<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\DatabaseTransactions;

use Laracasts\Behat\Context\Migrator;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

    use Migrator, DatabaseTransactions, AuthenticationFeature;


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
        $this->fillField('slug', 'ex-slug');
        $this->fillField('content', $content);
        $this->pressButton('Create Post');
        $this->printCurrentUrl();

    }

    /**
     * @Then I should see a post :title
     * @param $title
     */
    public function iShouldSeeAPost($title)
    {
        $this->visit('admin/posts');
        $this->printCurrentUrl();
        $this->assertPageContainsText($title);
    }
}
