<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

use function config;
use function dd;

class ClientEditUpdateController extends ClientCRUD
{
	use CRUDEditUpdateTrait;

	public $allowedMethods = ['edit', 'update'];

	public function getRelationshipsManagerClass()
	{
		return config("clients.models.client.relationshipsManagerClasses.edit");
	}

	public function edit(string $client)
	{
		$client = $this->findModel($client);

		return $this->_edit($client);
	}

	public function update(Request $request, $client)
	{
		$client = $this->findModel($client);

		return $this->_update($request, $client);
	}
}
