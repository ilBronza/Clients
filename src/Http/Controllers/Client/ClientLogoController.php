<?php

namespace IlBronza\Clients\Http\Controllers\Client;

use IlBronza\CRUD\Http\Controllers\Traits\ControllerLogoTrait;

class ClientLogoController extends ClientCRUD
{
	use ControllerLogoTrait;

	public $allowedMethods = ['logoFetcher'];

	public function logoFetcher(string $client)
	{
		$this->modelInstance = $this->findModel($client);

		return $this->returnLogoImage();
	}
}
