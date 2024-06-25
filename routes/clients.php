<?php

use App\Http\Controllers\TestController;

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
	'middleware' => ['web', 'auth', 'role:administrator'],
	'prefix' => 'clients-management',
	'as' => config('clients.routePrefix'),
	'routeTranslationPrefix' => 'clients::routes.',
	],
	function()
	{
		Route::resource('clients', Clients::getController('client'));

		Route::get('clients/{client}', [Clients::getController('client', 'show'), 'show'])->name('clients.show');

		Route::get('clients/{client}/edit', [Clients::getController('client', 'edit'), 'edit'])->name('clients.edit');

		Route::get(
			'clients/{client}/destinations/create',
			[
				Clients::getController('destination', 'create'),
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

		Route::get(
			'clients/{client}/clienthashes/create',
			[
				Clients::getController('clienthash'),
				'createFromClient'
			]
		)->name('clients.clienthashes.create');


		Route::resource('clienthashes', Clients::getController('clienthash'));


		Route::group(['prefix' => 'destinations'], function()
		{
			Route::get('', [Clients::getController('destination', 'index'), 'index'])->name('destinations.index');
			Route::get('create', [Clients::getController('destination', 'create'), 'create'])->name('destinations.create');
			Route::post('', [Clients::getController('destination', 'store'), 'store'])->name('destinations.store');
			Route::get('{destination}', [Clients::getController('destination', 'show'), 'show'])->name('destinations.show');
			Route::get('{destination}/edit', [Clients::getController('destination', 'edit'), 'edit'])->name('destinations.edit');
			Route::put('{destination}', [Clients::getController('destination', 'edit'), 'update'])->name('destinations.update');

			Route::delete('{destination}/delete', [Clients::getController('destination', 'destroy'), 'destroy'])->name('destinations.destroy');
		});



		// Route::resource('destinations', Clients::getController('destination'));
		Route::resource('referents', Clients::getController('referent'));
		Route::resource('destinationtypes', Clients::getController('destinationtype'));
		Route::resource('referenttypes', Clients::getController('referenttype'));



	});