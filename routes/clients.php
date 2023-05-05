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

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'clients-management',
	'as' => config('clients.routePrefix')
	],
	function()
	{
		Route::resource('clients', Clients::getController('client'));

		Route::get(
			'clients/{client}/destinations/create',
			[
				Clients::getController('destination'),
				'createFromClient'
			]
		)->name('clients.destinations.create');

		Route::get(
			'clients/{client}/referents/create',
			[
				Clients::getController('referent'),
				'createFromClient'
			]
		)->name('clients.referents.create');

		Route::resource('destinations', Clients::getController('destination'));
		Route::resource('referents', Clients::getController('referent'));
		Route::resource('destinationtypes', Clients::getController('destinationtype'));
		Route::resource('referenttypes', Clients::getController('referenttype'));
	});