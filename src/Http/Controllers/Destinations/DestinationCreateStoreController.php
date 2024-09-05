<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Ukn\Facades\Ukn;

class DestinationCreateStoreController extends DestinationCRUD
{
	use CRUDCreateStoreTrait;
	use CRUDShowTrait;
	use CRUDRelationshipTrait;

	public $returnBack = true;

	public $allowedMethods = ['create', 'store', 'createFromClient'];

	public function getGenericParametersFile() : ?string
	{
		return config('clients.models.destination.parametersFiles.create');
	}

	public function getRelationshipsManagerClass()
	{
		return config("products.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
	}

	public function createFromClient(int|string $client)
	{
		$client = Client::getProjectClassName()::find($client);

		$destination = $this->getModelClass()::make();
		$destination->client_id = $client->getKey();
		$destination->name = $client->getName();
		$destination->save();

		Ukn::s(__('clients::destinations.createdForClient', ['client' => $client->getName()]));

		return redirect()->to($destination->getEditUrl());
	}

	public function show(string $destination)
	{
		$destination = $this->findModel($destination);

		return $this->_show($destination);
	}
}
