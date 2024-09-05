<?php

use IlBronza\Clients\Http\Controllers\Client\ClientEditUpdateController;
use IlBronza\Clients\Http\Controllers\Client\ClientLogoController;
use IlBronza\Clients\Http\Controllers\Client\ClientShowController;
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
use IlBronza\Clients\Http\Parameters\Datatables\ClientRelatedFieldsGroupParametersFile;
use IlBronza\Clients\Http\Parameters\Datatables\DestinationFieldsGroupParametersFile;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientEditFieldsetsParameters;
use IlBronza\Clients\Http\Parameters\Fieldsets\ClientShowFieldsetsParameters;
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

return [
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

	'models' => [
		'client' => [
			'class' => Client::class,
			'table' => 'clients__clients',
            'parametersFiles' => [
                'show' => ClientShowFieldsetsParameters::class,
                'edit' => ClientEditFieldsetsParameters::class,
                // 'show' => ProductShowFieldsetsParameters::class,
                // 'teaser' => ProductShowFieldsetsParameters::class,
            ],
			'fieldsGroupsFiles' => [
				'related' => ClientRelatedFieldsGroupParametersFile::class
			],
			'controllers' => [
				'show' => ClientShowController::class,
				'edit' => ClientEditUpdateController::class,
				'logo' => ClientLogoController::class,
			],
            'relationshipsManagerClasses' => [
                'show' => ClientRelationshipsManager::class
            ],
			'controller' => CrudClientController::class,
		],

		'clienthash' => [
			'class' => Clienthash::class,
			'table' => 'clients__hashes',
			'controller' => CrudClienthashController::class
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

	'controllers' => [
		'clientController' => 'ELIMI_NARE__QUI_ZXC',
		'destinationController' => 'ELIMI_NARE__QUI_ASD',
		'referentController' => 'ELIMI_NARE__QUI_QWE'
	],

    'routePrefix' => 'clientsmanager',

	'destinationReferent' => [
		'table' => 'destination_referents'
	]
];