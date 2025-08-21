<?php

use IlBronza\Clients\Http\Controllers\Clienthashes\CrudClienthashCreateController;
use IlBronza\Clients\Http\Controllers\Clients\ClientByOperatorController;
use IlBronza\Clients\Http\Controllers\Clients\ClientCreateStoreController;
use IlBronza\Clients\Http\Controllers\Clients\ClientEditUpdateController;
use IlBronza\Clients\Http\Controllers\Clients\ClientIndexController;
use IlBronza\Clients\Http\Controllers\Clients\ClientLogoController;
use IlBronza\Clients\Http\Controllers\Clients\ClientShowController;
use IlBronza\Clients\Http\Controllers\CrudClientController;
use IlBronza\Clients\Http\Controllers\CrudClienthashController;
use IlBronza\Clients\Http\Controllers\CrudDestinationController;
use IlBronza\Clients\Http\Controllers\CrudDestinationtypeController;
use IlBronza\Clients\Http\Controllers\CrudReferentController;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationCreateStoreController;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationDestroyController;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationEditUpdateController;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationIndexController;
use IlBronza\Clients\Http\Controllers\Destinations\DestinationShowController;
use IlBronza\Clients\Http\Controllers\Referents\CrudReferenttypeController;
use IlBronza\Clients\Http\Parameters\Datatables\ClientIndexFieldsGroupParametersFile;
use IlBronza\Clients\Http\Parameters\Datatables\ClientRelatedFieldsGroupParametersFile;
use IlBronza\Clients\Http\Parameters\Datatables\DestinationFieldsGroupParametersFile;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientCreateFieldsetsParameters;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientEditFieldsetsParameters;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientShowFieldsetsParameters;
use IlBronza\Clients\Http\Parameters\Fieldsets\DestinationCreateStoreFieldsetsParameters;
use IlBronza\Clients\Http\Parameters\RelationshipsManagers\ClientRelationshipsManager;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Clienthash;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\DestinationReferent;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\DestinationtypeDestination;
use IlBronza\Clients\Models\Referent;
use IlBronza\Clients\Models\Referenttype;
use IlBronza\Clients\Models\ReferenttypeReferent;
use IlBronza\Clients\Providers\Helpers\ClientHashHelper;

return [
	'userArea' => [
		'enabled' => false,
	],
	'privateArea' => [
		'enabled' => false
	],
	'destinations' => [
		'enabled' => true
	],
	'referents' => [
		'enabled' => true
	],
	// 'client' => [
	// 	'class' => Client::class
	// ],

	// 'referent' => [
	// 	'class' => Referent::class,

	// 	'default_type' => 'default'
	// ],

	// 'destination' => [
	// 	'class' => Destination::class
	// ],


	'datatableFieldWidths' => [
		'client' => [
			'datatableFieldClient' => '16em',
			'datatableFieldVat' => '8em'
		]
	],

	'models' => [
		'client' => [
			'class' => Client::class,
			'table' => 'clients__clients',
			'parametersFiles' => [
				'create' => ClientCreateFieldsetsParameters::class,
				'show' => ClientShowFieldsetsParameters::class,
				'edit' => ClientEditFieldsetsParameters::class,
				// 'show' => ProductShowFieldsetsParameters::class,
				// 'teaser' => ProductShowFieldsetsParameters::class,
			],
			'fieldsGroupsFiles' => [
				'index' => ClientIndexFieldsGroupParametersFile::class,
				'related' => ClientRelatedFieldsGroupParametersFile::class
			],
			'controllers' => [
				'index' => ClientIndexController::class,
				'byOperator' => ClientByOperatorController::class,
				'create' => ClientCreateStoreController::class,
				'store' => ClientCreateStoreController::class,
				'show' => ClientShowController::class,
				'edit' => ClientEditUpdateController::class,
				'update' => ClientEditUpdateController::class,
				'logo' => ClientLogoController::class,
			],
			'relationshipsManagerClasses' => [
				'show' => ClientRelationshipsManager::class
			],
			//TODO ELIMINARE
			'controller' => CrudClientController::class,
		],

		'clienthash' => [
			'class' => Clienthash::class,
			'table' => 'clients__hashes',
			'controller' => CrudClienthashController::class,
			'helpers' => [
				'creator' => ClientHashHelper::class
			],
			'controllers' => [
				'create' => CrudClienthashCreateController::class,
			]
		],

		'destinatable' => [
			'class' => Destinatable::class,
			'table' => 'clients__destinatable',
		],

		'destination' => [
			'class' => Destination::class,
			'table' => 'clients__destinations',
			'controller' => CrudDestinationController::class,
			'fieldsGroupsFiles' => [
				'index' => DestinationFieldsGroupParametersFile::class,
				'related' => DestinationFieldsGroupParametersFile::class,
			],
			'parametersFiles' => [
				'create' => DestinationCreateStoreFieldsetsParameters::class,
				'show' => DestinationShowFieldsetsParameters::class
			],
			'relationshipsManagerClasses' => [
				'show' => DestinationRelationManager::class
			],
			'controllers' => [
				'index' => DestinationIndexController::class,
				'create' => DestinationCreateStoreController::class,
				'store' => DestinationCreateStoreController::class,
				'show' => DestinationShowController::class,
				'edit' => DestinationEditUpdateController::class,
				'update' => DestinationEditUpdateController::class,
				'destroy' => DestinationDestroyController::class,
			]
		],
		'destinationtypeDestination' => [
			'table' => 'clients__destinationtype_destinations',
			'class' => DestinationtypeDestination::class,
		],
		'destinationtype' => [
			'class' => Destinationtype::class,
			'table' => 'clients__destinationtypes',
			'controller' => CrudDestinationtypeController::class,
			'defaultName' => 'default',
			'legalName' => 'legal'
		],
		'referenttype' => [
			'class' => Referenttype::class,
			'table' => 'clients__referenttypes',
			'controller' => CrudReferenttypeController::class,
			'defaultName' => 'default'
		],
		'referenttypeReferent' => [
			'table' => 'clients__referenttype_referents',
			'class' => ReferenttypeReferent::class,
		],
		'referent' => [
			'class' => Referent::class,
			'table' => 'clients__referents',
			'controller' => CrudReferentController::class
		],
		'destinationReferent' => [
			'class' => DestinationReferent::class,
			'table' => 'clients__destination_referent'
		]
	],

	'routePrefix' => 'clientsmanager',

	'destinationReferent' => [
		'table' => 'destination_referents'
	]
];