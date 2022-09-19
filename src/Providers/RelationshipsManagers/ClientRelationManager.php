<?php

namespace IlBronza\Clients\Providers\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager;

use IlBronza\Clients\Http\Controllers\CrudDestinationController;
use IlBronza\Clients\Http\Controllers\CrudReferentController;

class ClientRelationManager Extends RelationshipsManager
{
	public function getAllRelationsParameters()
	{
		return [
			'show' => [
				'relations' => [
					'destinations' => CrudDestinationController::class,
					'referents' => CrudReferentController::class
				]
			]
		];
	}
}