<?php

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Referent;

return [
	'client' => [
		'class' => Client::class
	],

	'referent' => [
		'class' => Referent::class,

		'default_type' => 'default'
	],

	'destination' => [
		'class' => Destination::class
	],
];