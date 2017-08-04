<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controllers\MusicsController;

class MusicsTest extends TestCase
{
	public function testIndex(){
		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/music');
		$response->assertViewIs('music');

		$response = $this->withSession(['administrator' => 0, 'login' => true])->get('/music');
		$response->assertRedirect('/');

		$this->get('/music')->assertRedirect('/');
	}

	public function testSave(){
		$this->assertTrue(true);
	}

	public function testRank(){
		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/rank');
		$response->assertViewIs('rank');

		$response = $this->withSession(['administrator' => 0, 'login' => true])->get('/music');
		$response->assertRedirect('/');

		$this->get('/rank')->assertRedirect('/');
	}

	public function testSearch(){
		$this->assertTrue(true);
	}

	public function testExit(){
		$this->get('/exit')->assertRedirect('/');
	}
}
