<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

use App\Model\Users;
use App\Model\Musics;
use App\Model\Favorites;

class FavoritesTest extends TestCase
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


	public function testAccessDeniedList(){
		$response = $this->withSession(['administrator' => 1, 'login' => false])->get('/list');
		$response->assertRedirect('/');
	}

	public function testAccessAcceptList(){
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

		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/list');
		$response->assertViewIs('list');
		$response->assertViewHas('musics');
	}

	public function testAddDenied(){
		$response = $this->withSession(['login' => false])->get('/add');
		$response->assertRedirect('/');
	}

	public function testAddMusicFavorites(){
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$idUser = $this->users->id;

		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$idMusic = $this->musics->id;

		$response =  $this->withSession(['login' => $idUser])->get('/add/' . $idMusic);
		$response->assertRedirect('/list');

		$this->assertDatabaseHas('favorites', [
			'id_music' => $idMusic,
			'id_user' => $idUser,
			'name' => 'One',
			'style' => 'Rock',
			'artist' => 'Metallica'
			]);
	}

	public function testAccessDeniedFavorites(){
		$response = $this->withSession(['administrator' => 1, 'login' => false])->get('/favorites');
		$response->assertRedirect('/');
	}

	public function testFavorites(){
		$response = $this->withSession(['administrator' => 1, 'login' => true])->get('/favorites');
		$response->assertViewIs('favorites');
		$response->assertViewHas('favorites');
	}

	public function testRemoveDenied(){
		$response = $this->withSession(['login' => false])->get('/add');
		$response->assertRedirect('/');
	}

	public function testRemoveMusicFavorites(){
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$idUser = $this->users->id;

		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$idMusic = $this->musics->id;

		$this->favorites->id_user = $this->users->id;
		$this->favorites->id_music = $this->musics->id;
		$this->favorites->name = 'One';
		$this->favorites->style = 'Rock';
		$this->favorites->artist = 'Metallica';
		$this->favorites->save();

		$idFavorite = $this->favorites->id;

		$response =  $this->withSession(['login' => $idUser])->get('/remove/' . $idFavorite);
		$response->assertRedirect('/favorites');

		$this->assertDatabaseMissing('favorites', [
			'id' => $idFavorite,
			'id_music' => $idMusic,
			'id_user' => $idUser,
			'name' => 'One',
			'style' => 'Rock',
			'artist' => 'Metallica'
			]);
	}

	public function testDeniedFind(){
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$idUser = $this->users->id;

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

		$response = $this->withSession(['login' => false])->json('POST', '/find', array('search' => 'one'));
		$response->assertRedirect('/');
	}

	public function testFoundFind(){
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$idUser = $this->users->id;

		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$idMusic = $this->musics->id;

		$response = $this->withSession(['login' => $idUser])->json('POST', '/find', array('search' => 'Rock'));
		$response->assertViewIs('list');
		$response->assertViewHas('musics');
	}

	public function testNotFoundFind(){
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 25;
		$this->users->save();

		$idUser = $this->users->id;

		$this->musics->name = 'One';
		$this->musics->style = 'Rock';
		$this->musics->artist = 'Metallica';
		$this->musics->save();

		$idMusic = $this->musics->id;

		$this->favorites->id_user = $idUser;
		$this->favorites->id_music = $idMusic;
		$this->favorites->name = 'One';
		$this->favorites->style = 'Rock';
		$this->favorites->artist = 'Metallica';
		$this->favorites->save();

		$response = $this->withSession(['login' => $idUser])->json('POST', '/find', array('search' => 'Rock'));
		$response->assertViewIs('list');
		$response->assertViewHas('musics');
		$response->assertViewHas('message', 'Não foi encontrado nenhum Artista ou Estilo, de acordo com sua busca');
	}

	public function testQuit(){
		$response = $this->get('/quit');
		$response->assertSessionHas('login', false);
		$response->assertSessionHas('administrator', false);
		$response->assertRedirect('/');
	}

	public function tearDown(){
		DB::rollback();
	}
}
