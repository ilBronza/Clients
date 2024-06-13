<?php

namespace IlBronza\Clients\Http\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Notes\Http\Controllers\CrudNoteController;

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
		$relations['filecabinets'] = config('filecabinet.models.filecabinet.controllers.index');

		$relations['dossiers'] = config('filecabinet.models.dossier.controllers.index');

		if(config('products.sellables.enabled'))
			$relations['projects'] = config('products.models.project.controllers.index');

		if(config('products.sellables.enabled'))
			$relations['quotations'] = config('products.models.quotation.controllers.index');

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
		];	}
}