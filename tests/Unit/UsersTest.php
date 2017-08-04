<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

use App\Model\Users;

class UsersTest extends TestCase
{
	private $users;

	public function setUp()
	{
		parent::setUp();
		$this->users = new Users;
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
		
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 23;
		$this->users->save();

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
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'testeadmin@yahoo.com.br';
		$this->users->age = 23;
		$this->users->administrator = 1;
		$this->users->save();

		$response = $this->json('POST', '/login', array(
			'email' => 'testeadmin@yahoo.com.br',
			'password' => '123'
			));

		$response->assertRedirect('/music');
	}

	public function testLoginComumUser()
	{
		$this->users = new Users;
		$this->users->name = 'Teste';
		$this->users->password = encrypt('123');
		$this->users->email = 'teste@yahoo.com.br';
		$this->users->age = 23;
		$this->users->save();

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
