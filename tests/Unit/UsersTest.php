<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

use App\Model\Users;

class UsersTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		DB::beginTransaction();
	}

	public function testAddAdminUser()
	{
		$response = $this->json('POST', '/create', array(
			'name' => 'Teste Admin',
			'password' => '123',
			'email' => 'testeadmin@yahoo.com.br',
			'administrator' => 1,
			'age' => 25
			));

		$response->assertStatus(302);
	}

	public function testAddComumUser()
	{
		$response = $this->json('POST', '/create', array(
			'name' => 'Teste',
			'password' => '123',
			'email' => 'teste@yahoo.com.br',
			'age' => 25
			));

		$response->assertStatus(302);
	}

	public function testAddRepeatUser()
	{
		$users = new Users;
		$users->name = 'Teste';
		$users->password = encrypt('123');
		$users->email = 'teste@yahoo.com.br';
		$users->age = 23;
		$users->save();

		$response = $this->json('POST', '/create', array(
			'name' => 'Teste',
			'password' => '123',
			'email' => 'teste@yahoo.com.br',
			'age' => 25
			));

		$response->assertViewIs('register');
	}

	public function testLoginAdminUser()
	{
		$users = new Users;
		$users->name = 'Teste';
		$users->password = encrypt('123');
		$users->email = 'testeadmin@yahoo.com.br';
		$users->age = 23;
		$users->administrator = 1;
		$users->save();

		$response = $this->json('POST', '/login', array(
			'email' => 'testeadmin@yahoo.com.br',
			'password' => '123'
			));

		$response->assertRedirect('/music');
	}

	public function testLoginComumUser()
	{
		$users = new Users;
		$users->name = 'Teste';
		$users->password = encrypt('123');
		$users->email = 'teste@yahoo.com.br';
		$users->age = 23;
		$users->save();

		$response = $this->json('POST', '/login', array(
			'email' => 'teste@yahoo.com.br',
			'password' => '123'
			));

		$response->assertRedirect('/list');
	}

	public function tearDown(){
		DB::rollback();
	}
}
