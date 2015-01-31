<?php
/**
 * Created by PhpStorm.
 * User: harryg
 * Date: 28/01/15
 * Time: 23:08
 */

use PHPUnit_Framework_Assert as PHPUnit;

trait AuthenticationFeature {

    protected $name;
    protected $email;
    protected $password = 'password';
    protected $password_confirm = 'password';

    /**
     * @param string $name
     * @param string $email
     * @When I register :name :email
     */
    public function iRegister($name, $email)
    {
        $this->name = $name;
        $this->email = $email;

        $this->visit('register');

        $this->fillField('name', $name);
        $this->fillField('email', $email);
        $this->fillField('password', $this->password);
        $this->fillField('password_confirmation', $this->password_confirm);

        $this->pressButton('Register');
    }

    /**
     * @Then I should have an account
     */
    public function iShouldHaveAnAccount()
    {
        $this->assertSignedIn();
    }

    /**
     * @Given I am logged out
     */
    public function iAmLoggedOut()
    {
        $this->visit('logout');
    }

    /**
     * @When I log in
     */
    public function iLogIn()
    {
        $this->visit('login');
        $this->fillField('email', $this->email);
        $this->fillField('password', 'password');
        $this->pressButton('Login');
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn()
    {
        $this->assertSignedIn();
    }

    /**
     * @Given I have an account :name :email
     * @param $name
     * @param $email
     */
    public function iHaveAnAccount($name, $email)
    {
        $this->iRegister($name, $email);
    }

    private function assertSignedIn()
    {
        PHPUnit::assertTrue(\Auth::check());
    }


    /**
     * @When I log in with invalid credentials
     */
    public function iLogInWithInvalidCredentials()
    {
        $this->email = "invalid@bad.com";
        $this->iLogIn();
    }

    /**
     * @Then I should not be logged in
     */
    public function iShouldNotBeLoggedIn()
    {
        PHPUnit::assertTrue(\Auth::guest());
    }

    /**
     * @Then I should not have an account
     */
    public function iShouldNotHaveAnAccount()
    {
        $this->iShouldNotBeLoggedIn();
    }

    /**
     * @When I register with unmatched passwords :name :email
     * @param $name
     * @param $email
     */
    public function iRegisterWithUnmatchedPasswords($name, $email)
    {
        $this->password_confirm = 'unmatching';
        $this->iRegister($name, $email);
    }
}