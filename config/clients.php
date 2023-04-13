<?php

use IlBronza\Clients\Http\Controllers\CrudClientController;
use IlBronza\Clients\Http\Controllers\CrudDestinationController;
use IlBronza\Clients\Http\Controllers\CrudReferentController;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\DestinationReferent;
use IlBronza\Clients\Models\Referent;

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
			'table' => 'clientsclients'
		],
		'destination' => [
			'class' => Destination::class,
			'table' => 'clientsdestinations'
		],
		'referent' => [
			'class' => Referent::class,
			'table' => 'clientsreferents'
		],
		'destinationReferent' => [
			'class' => DestinationReferent::class,
			'table' => 'clientsdestination_referent'
		]
	],

	'controllers' => [
		'clientController' => CrudClientController::class,
		'destinationController' => CrudDestinationController::class,
		'referentController' => CrudReferentController::class
	],

    'routePrefix' => 'clientsmanager',

	'destinationReferent' => [
		'table' => 'destination_referents'
	]
];