<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function(){
	Route::get('/', 'UsersController@index');
	Route::post('/login', 'UsersController@login');

	Route::get('/music', 'MusicsController@index');
	Route::post('/save', 'MusicsController@save');

	Route::get('/rank', 'MusicsController@rank');
	Route::get('/search', 'MusicsController@search');

	Route::get('/exit', 'MusicsController@exit');

	Route::get('/list', 'FavoritesController@index');
	Route::get('/add/{id}', 'FavoritesController@add');

	Route::get('/favorites', 'FavoritesController@favorites');
	Route::get('/remove/{id}', 'FavoritesController@remove');

	Route::post('/find', 'FavoritesController@find');

	Route::get('/quit', 'FavoritesController@quit');

	Route::get('/register', 'UsersController@register');
	Route::post('/create', 'UsersController@create');
});