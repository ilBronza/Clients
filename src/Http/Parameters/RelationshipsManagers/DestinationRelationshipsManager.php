<?php

namespace IlBronza\Clients\Http\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;
use IlBronza\Notes\Http\Controllers\CrudNoteController;

class DestinationRelationshipsManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$relations = [
			'client' => config('clients.models.client.controllers.show'),
			'types' => config('clients.models.destinationtype.controller'),
			'referents' => config('clients.models.referent.controller')
		];

		if(config('payments.active', false) === true)
			$relations['bankAccounts'] = [
				'relation' => 'bankaccounts',
				'controller' => config('payments.models.bankaccount.controllers.index'),
				'elementGetterMethod' => 'getRelatedBankaccountElements',
			];

		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}
