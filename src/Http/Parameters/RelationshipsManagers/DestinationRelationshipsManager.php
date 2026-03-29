<?php

namespace IlBronza\Clients\Http\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Notes\Http\Controllers\CrudNoteController;

class DestinationRelationshipsManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		return [
			'show' => [
				'relations' => [
					'client' => config('clients.models.client.controllers.show'),
					'types' => config('clients.models.destinationtype.controller'),
					'referents' => config('clients.models.referent.controller')
				]
			]
		];
	}
}