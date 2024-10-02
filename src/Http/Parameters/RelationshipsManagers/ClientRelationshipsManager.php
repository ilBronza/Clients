<?php

namespace IlBronza\Clients\Http\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Notes\Http\Controllers\CrudNoteController;

use function config;

class ClientRelationshipsManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$relations = [];

		try
		{
			app('products');

			$relations['makingOrders'] = [
				'controller' => config('products.models.order.controllers.index'),
				// 'elementGetterMethod' => 'getMakingOrdersForShowRelation',
				'translatedTitle' => 'Commesse in corso'
			];

			$relations['orders'] = [
				'controller' => config('products.models.order.controllers.index'),
				// 'elementGetterMethod' => 'getOrdersForShowRelation'
			];

			// $relations['products'] = [
			// 	'controller' => config('products.models.product.controllers.index'),
			// 	'elementGetterMethod' => 'getProductsForShowRelation',
			// 	'fieldsGroupsNames' => ['clientRelated']
			// ];

		}
		catch(\Exception $e)
		{
			
		}

		// if(app('clients')->hasClientPrivateArea())
		// 	$relations['hashes'] = CrudClienthashController::class;

		// $this->getModel()

		if(config('operators.enabled', true))
			$relations['operators'] = config('operators.models.operator.controllers.index');

		if(config('filecabinets.enabled'))
			$relations['filecabinets'] = config('filecabinet.models.filecabinet.controllers.index');

		if(config('filecabinets.enabled'))
			$relations['dossiers'] = config('filecabinet.models.dossier.controllers.index');

		if(config('products.sellables.enabled'))
			$relations['projects'] = config('products.models.project.controllers.index');

		if(config('products.sellables.enabled'))
			$relations['supplier'] = config('products.models.supplier.controllers.show');

		if(app('clients')->hasDestinations())
			$relations['destinations'] = config('clients.models.destination.controllers.index');

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
		];	}
}