<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;

use function config;

class ClientCreateStoreController extends ClientCRUD
{
	use CRUDCreateStoreTrait;
	use CRUDRelationshipTrait;

	public $allowedMethods = [
		'create',
		'store',
	];

	public function getCreateParametersFile() : ? string
	{
		return config('clients.models.client.parametersFiles.create');
	}
}
