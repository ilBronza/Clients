<?php

use IlBronza\Clients\Http\Controllers\CrudClientController;
use IlBronza\Clients\Http\Controllers\CrudDestinationController;
use IlBronza\Clients\Http\Controllers\CrudReferentController;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\DestinationReferent;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referent;
use IlBronza\Clients\Models\Referenttype;

return [
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
			'controller' => CrudClientController::class
		],
		'destination' => [
			'class' => Destination::class,
			'table' => 'clients__destinations',
			'controller' => CrudDestinationController::class
		],
		'destinationtypeDestination' => [
			'table' => 'clients__destinationtype_destinations'
		],
		'destinationtype' => [
			'class' => Destinationtype::class,
			'table' => 'clients__destinationtypes',
			'defaultName' => 'default'
		],
		'referenttype' => [
			'class' => Referenttype::class,
			'table' => 'clients__referenttypes',
			'defaultName' => 'default'
		],
		'referenttypeReferent' => [
			'table' => 'clients__referenttype_referents'
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