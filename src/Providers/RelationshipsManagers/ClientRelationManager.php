<?php

namespace IlBronza\Clients\Providers\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager;
use IlBronza\Clients\Http\Controllers\CrudClienthashController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Products\Http\Controllers\Product\ProductIndexController;


class ClientRelationManager Extends RelationshipsManager
{
	public function getAllRelationsParameters()
	{
		$relations = [];

		try
		{
			app('products');

			$relations['makingOrders'] = config('products.models.order.controllers.index');
			$relations['notes'] = CrudNoteController::class;
			$relations['orders'] = config('products.models.order.controllers.index');
			$relations['products'] = [
				'controller' => config('products.models.product.controllers.index'),
				'fieldsGroupsNames' => ['clientRelated']
			];

		}
		catch(\Exception $e)
		{
			
		}

		if(app('clients')->hasClientPrivateArea())
			$relations['hashes'] = CrudClienthashController::class;

		if(app('clients')->hasDestinations())
			$relations['destinations'] = config('clients.models.destination.controller');

		if(app('clients')->hasReferents())
			$relations['referents'] = config('clients.models.referent.controller');


		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}