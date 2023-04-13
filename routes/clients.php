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
		Route::resource('clients', config('clients.controllers.clientController'));

		Route::get('clients/{client}/destinations/create', [CrudDestinationController::class, 'createFromClient'])->name('clients.destinations.create');
		Route::get('clients/{client}/referents/create', [CrudReferentController::class, 'createFromClient'])->name('clients.referents.create');


		Route::resource('destinations', config('clients.controllers.destinationController'));
		Route::resource('referents', config('clients.controllers.referentController'));
	});