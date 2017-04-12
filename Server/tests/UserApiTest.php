<?php

use App\User;

class UserApiTest extends TestCase {

  public function setUp() {
    parent::setUp();
    \Illuminate\Support\Facades\Artisan::call('migrate');
  }

  public function testGetUsers() {
    $user = User::create(['id_user' => '1']);
    $this->assertEquals(1, Comment::count());
  }

}
