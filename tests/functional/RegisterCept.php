<?php 
$I = new FunctionalTester($scenario);

$I->am('a guest');
$I->wantTo("Sign up for an account");

$I->amOnPage("/register");

$I->fillField('name', 'John');
$I->fillField('email', 'john@example.com');
$I->fillField('password', 'password');
$I->fillField('password_confirmation', 'password');
$I->click('Register');


$I->seeCurrentUrlEquals("/home");
$I->seeRecord('users', array('name' => 'John'));
$I->amLoggedAs('John');