<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\UsersController;

class UsersTest extends TestCase{

	public function testIndex(){
		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/');
		$response->assertRedirect('/music');

		$response = $this->withSession(['administrator' => 0, 'login' => true])->get('/');
		$response->assertRedirect('/list');

		$this->get('/')->assertViewIs('index');
	}

	public function testLogin(){
		$this->assertTrue(true);

	}

	public function testCreate(){
		$this->assertTrue(true);
	}
}
