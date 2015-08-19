<?php namespace Integration;

use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
  use DatabaseTransactions;

  function testItCanEditUserProfile()
  {
    $this->loginWithUser();

    $this->visit('/admin/profile');
  }

}
