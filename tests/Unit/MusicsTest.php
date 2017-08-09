<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

use App\Model\Users;
use App\Model\Musics;
use App\Model\Favorites;

class MusicsTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

		//$this->artisan('migrate:refresh');

		$this->users = new Users;
		$this->musics = new Musics;
		$this->favorites = new Favorites;

		DB::beginTransaction();
	}

	public function testAccessWithAdministrator(){
		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/music');
		$response->assertViewIs('music');
	}

	public function testAccessWithComumUser(){
		$response = $this->withSession(['administrator' => 0, 'login' => true])->get('/music');
		$response->assertRedirect('/');
	}

	public function testAccessWithoutLogin(){
		$response = $this->withSession(['administrator' => 0, 'login' => false])->get('/music');
		$response->assertRedirect('/');
	}

	public function testSaveNewUser(){
		$response = $this->json('POST', '/save', array('name' => 'One', 'style' => 'Rock', 'artist' => 'Metallica'));
		$response->assertRedirect('/music');

		$this->assertDatabaseHas('musics', [
	        'name' => 'One',
	        'style' => 'Rock',
	        'artist' => 'Metallica'
   		]);
	}

	public function testSaveWithExistUser(){
		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$response = $this->json('POST', '/save', array('name' => 'One', 'style' => 'Rock', 'artist' => 'Metallica'));
		$response->assertViewIs('music');
		$response->assertViewHas('message', 'Essa música já foi cadastrada');
	}

	public function testAccessRankAsAdministrator(){
		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/rank');
		$response->assertViewIs('rank');
		$response->assertViewHas('favorites');

		$this->assertDatabaseHas('musics', [
	        'name' => 'One',
	        'style' => 'Rock',
	        'artist' => 'Metallica'
   		]);
	}

	public function testAccessRankAsComumUser(){
		$response = $this->withSession(['administrator' => 0, 'login' => true])->get('/rank');
		$response->assertRedirect('/');
	}

	public function testAccessRankWithoutLogin(){
		$response = $this->withSession(['administrator' => 0, 'login' => false])->get('/rank');
		$response->assertRedirect('/');
	}

	public function testSearch(){

		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$this->favorites->id_user = $this->users->id;
    	$this->favorites->id_music = $this->musics->id;
    	$this->favorites->name = 'One';
    	$this->favorites->style = 'Rock';
    	$this->favorites->artist = 'Metallica';
        $this->favorites->save();

		$response = $this->json('GET', '/search', array('search' => 'name'));
		$response->assertJsonFragment(['val' => 'One']);

		$response = $this->json('GET', '/search', array('search' => 'style'));
		$response->assertJsonFragment(['val' => 'Rock']);

		$response = $this->json('GET', '/search', array('search' => 'artist'));
		$response->assertJsonFragment(['val' => 'Metallica']);

		$response = $this->json('GET', '/search', array('search' => ''));
		$response->assertJsonFragment(['name' => 'One', 'style' => 'Rock', 'artist' => 'Metallica']);
	}

	public function testExit(){
		$response = $this->get('/exit');
		$response->assertSessionHas('login', false);
		$response->assertSessionHas('administrator', false);
		$response->assertRedirect('/');
	}

	public function tearDown(){
		DB::rollback();
	}
}
