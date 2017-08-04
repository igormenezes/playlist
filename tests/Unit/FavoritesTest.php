<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Controller\FavoritesController;

class FavoritesTest extends TestCase
{
	public function testIndex(){
		$response = $this->withSession(['administrator' => 1, 'login' => false])->get('/list');
		$response->assertRedirect('/');
	}

	public function testAdd(){
		$this->assertTrue(true);
	}

	public function testFavorites(){
		$response = $this->withSession(['administrator' => 1, 'login' => false])->get('/favorites');
		$response->assertRedirect('/');
	}

	public function testRemove(){
		$this->assertTrue(true);
	}

	public function testFind(){
		$this->assertTrue(true);
	}

	public function testQuit(){
		$this->get('/quit')->assertRedirect('/');
	}
}
