<?php

use IlBronza\Clients\Http\Controllers\CrudClientController;
use IlBronza\Clients\Http\Controllers\CrudDestinationController;
use IlBronza\Clients\Http\Controllers\CrudReferentController;

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
	],
	function()
	{
		Route::resource('clients', CrudClientController::class);

		Route::get('clients/{client}/destinations/create', [CrudDestinationController::class, 'createFromClient'])->name('clients.destinations.create');
		Route::get('clients/{client}/referents/create', [CrudReferentController::class, 'createFromClient'])->name('clients.referents.create');


		Route::resource('destinations', CrudDestinationController::class);
		Route::resource('referents', CrudReferentController::class);
	});