<?php

use IlBronza\Clients\Http\Controllers\CrudClientController;
use IlBronza\Clients\Http\Controllers\CrudDestinationController;

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

Route::group(['middleware' => ['auth', 'role:administrator']], function () {

	Route::group(['prefix' => 'clients'], function()
	{
		Route::get('', [CrudClientController::class, 'index'])->name('clients.index');

		Route::get('clients/{client}/destinations/create', [CrudDestinationController::class, 'createFromClient'])->name('clients.destinations.create');
		Route::get('clients/{client}/referents/create', [CrudReferentController::class, 'createFromClient'])->name('clients.referents.create');

	});
});
