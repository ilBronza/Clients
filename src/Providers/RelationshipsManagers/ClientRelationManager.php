<?php

namespace IlBronza\Clients\Providers\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\CRUD\Providers\RouterProvider\IbRouter;
use IlBronza\Clients\Http\Controllers\CrudClienthashController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Products\Http\Controllers\Product\ProductIndexController;
use IlBronza\Products\Models\Order;


class ClientRelationManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$relations = [];

		try
		{
			app('products');

			$relations['makingOrders'] = [
				'controller' => config('products.models.order.controllers.index'),
				'elementGetterMethod' => 'getMakingOrdersForShowRelation'
			];

			$relations['orders'] = [
				'controller' => config('products.models.order.controllers.index'),
				'elementGetterMethod' => 'getOrdersForShowRelation'
			];

			$relations['products'] = [
				'controller' => config('products.models.product.controllers.index'),
				'elementGetterMethod' => 'getProductsForShowRelation',
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
		try
		{
			app('products');



			$relations['notes'] = CrudNoteController::class;

		}
		catch(\Exception $e)
		{
			
		}



		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}