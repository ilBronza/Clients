<?php

namespace IlBronza\Clients\Http\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Notes\Http\Controllers\CrudNoteController;

use IlBronza\Products\Http\Controllers\Providers\FieldsGroups\OrderrowFieldsGroupParametersFile;
use IlBronza\Products\Http\Controllers\Providers\FieldsGroups\SellableSupplierBySupplierFieldsGroupParametersFile;

use IlBronza\Products\Models\Orders\Orderrow;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function app;
use function config;

class ClientRelationshipsManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$relations = [];

			if(config('products.sellables.enabled'))
			{
				if($this->getModel()->isSupplier())
				{
					//SellableSupplierIndexController
					$relations['sellableSuppliers'] = [
						'controller' => config('products.models.sellableSupplier.controllers.index'),
						'fieldsGroupsParametersFile' => SellableSupplierBySupplierFieldsGroupParametersFile::class,
						'elementGetterMethod' => 'getSellableSuppliers',
						'buttonsMethods' => [
							'getCreateSellableSupplierButton',
						],
					];
				}
			}

//			$relations['makingOrders'] = [
//				'controller' => config('products.models.order.controllers.index'),
//				// 'elementGetterMethod' => 'getMakingOrdersForShowRelation',
//				'translatedTitle' => 'Commesse in corso'
//			];
//

		if(config('products.sellables.enabled'))
		{
			$relations['quotations'] = [
				'controller' => config('products.models.quotation.controllers.index'),
				// 'elementGetterMethod' => 'getOrdersForShowRelation'
			];

//			$relations['orders'] = [
//				'controller' => config('products.models.order.controllers.index'),
//				'elementGetterMethod' => 'getOrdersForShowRelation'
//			];

			$relations['orderrows'] = [
				'relationType' => 'HasMany',
				'relatedModelClass' => Orderrow::gpc(),
				'relatedModel' => ORderrow::gpc()::make(),
				'fieldsGroupsParametersFile' => OrderrowFieldsGroupParametersFile::class,
				'controller' => config('products.models.orderrow.controllers.index'),
				'elementGetterMethod' => 'getOrderrowsForShowRelation'
			];
		}

			// $relations['products'] = [
			// 	'controller' => config('products.models.product.controllers.index'),
			// 	'elementGetterMethod' => 'getProductsForShowRelation',
			// 	'fieldsGroupsNames' => ['clientRelated']
			// ];


		// if(app('clients')->hasClientPrivateArea())
		// 	$relations['hashes'] = CrudClienthashController::class;

		// $this->getModel()

//		if(config('operators.enabled', true))
//			$relations['operators'] = config('operators.models.operator.controllers.index');
//
//		if(config('filecabinets.enabled'))
//			$relations['filecabinets'] = config('filecabinet.models.filecabinet.controllers.index');

//		if(config('filecabinets.enabled'))
			$relations['dossiers'] = config('filecabinet.models.dossier.controllers.index');

//		if(config('products.sellables.enabled'))
//			$relations['projects'] = config('products.models.project.controllers.index');

//		if(config('products.sellables.enabled'))
//			$relations['supplier'] = config('products.models.supplier.controllers.show');
//
		if(app('clients')->hasDestinations())
			$relations['destinations'] = config('clients.models.destination.controllers.index');

		if(config('filecabinets.enabled'))
			$relations['dossiers'] = config('filecabinet.models.dossier.controllers.index');

		if(app('clients')->hasReferents())
			$relations['referents'] = config('clients.models.referent.controller');

		if(config('notes.enabled'))
			$relations['notes'] = CrudNoteController::class;

		return [
			'show' => [
				'relations' => $relations
			]
		];	}
}