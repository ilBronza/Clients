<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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
	'middleware' => [
		'web',
		'auth',
		'role:administrator|clientsManager'
	],
	'prefix' => 'clients-management',
	'as' => config('clients.routePrefix'),
	'routeTranslationPrefix' => 'clients::routes.',
	],
	function()
	{
		Route::get('clients/logo/{client}/logo-fetcher', [Clients::getController('client', 'logo'), 'logoFetcher'])->name('clients.logoFetcher');

		Route::resource('clients', Clients::getController('client'));

		Route::get('clients', [Clients::getController('client', 'index'), 'index'])->name('clients.index');

		//ClientByOperatorIndexController
		Route::get('clients-by-operator/{operator?}', [Clients::getController('client', 'byOperator'), 'index'])->name('clients.byOperator')->withoutMiddleware('role:administrator')->middleware('auth', 'role:clientsManager|areaManager|administrator');

		Route::get('clients/create', [Clients::getController('client', 'create'), 'create'])->name('clients.create');
		Route::post('clients', [Clients::getController('client', 'store'), 'store'])->name('clients.store');
		Route::get('clients/{client}', [Clients::getController('client', 'show'), 'show'])->name('clients.show')->withoutMiddleware('role:administrator')->middleware('auth', 'role:clientsManager|areaManager|administrator');

		//ClientEditUpdateController
		Route::get('clients/{client}/edit', [Clients::getController('client', 'edit'), 'edit'])->name('clients.edit');

//		Route::get('clients/{client}/edit', function($client) {
//			dd('asd');
//		})->name('clients.edit');
		
		Route::put('clients/{client}', [Clients::getController('client', 'update'), 'update'])->name('clients.update');

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

		//CrudClienthashController
		Route::post('clients/clienthashes/send', [Clients::getController('clienthash', 'create'), 'send'])->name('clients.clienthashes.send');


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