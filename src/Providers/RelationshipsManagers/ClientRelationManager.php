<?php

namespace IlBronza\Clients\Providers\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager;

class ClientRelationManager Extends RelationshipsManager
{
	public function getAllRelationsParameters()
	{
		return [
			'show' => [
				'relations' => [
					'destinations' => config('clients.models.destination.controller'),
					'referents' => config('clients.models.referent.controller')
				]
			]
		];
	}
}