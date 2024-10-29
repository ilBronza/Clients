<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class ClientShowController extends ClientCRUD
{
	use CRUDShowTrait;
	use CRUDRelationshipTrait;

	public $allowedMethods = ['show'];

	public function getExtendedShowButtons()
	{
		if (app('clients')->hasDestinations())
			$this->showButtons[] = $this->modelInstance->getCreateDestinationButton();

		if (app('clients')->hasReferents())
			$this->showButtons[] = $this->modelInstance->getCreateReferentButton();

		if (app('clients')->hasClientPrivateArea())
			$this->showButtons[] = $this->modelInstance->getCreateHashButton();
	}

	public function show(string $type)
	{
		$type = $this->findModel($type);

		return $this->_show($type);
	}
}
