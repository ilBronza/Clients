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
		Route::resource('clients', config('clients.models.client.controller'));

		Route::get(
			'clients/{client}/destinations/create',
			[
				config('clients.models.destination.controller'),
				'createFromClient'
			]
		)->name('clients.destinations.create');

		Route::get(
			'clients/{client}/referents/create',
			[
				config('clients.models.referent.controller'),
				'createFromClient'
			]
		)->name('clients.referents.create');


		Route::resource('destinations', config('clients.models.destination.controller'));
		Route::resource('referents', config('clients.models.referent.controller'));

		Route::resource('destinationtypes', config('clients.models.destinationtype.controller'));

		Route::resource('referenttypes', config('clients.models.referenttype.controller'));
	});