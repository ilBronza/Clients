<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;

class ClientEditUpdateController extends ClientCRUD
{
	use CRUDEditUpdateTrait;

	public $allowedMethods = ['edit', 'update'];

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
