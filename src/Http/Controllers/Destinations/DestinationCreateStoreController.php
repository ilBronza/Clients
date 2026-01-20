<?php

namespace IlBronza\Clients\Http\Controllers\Destinations;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Ukn\Ukn;

use function __;
use function config;
use function redirect;

class DestinationCreateStoreController extends DestinationCRUD
{
	use CRUDCreateStoreTrait;
	use CRUDShowTrait;
	use CRUDRelationshipTrait;

	public $returnBack = true;

	public $allowedMethods = ['create', 'store', 'createFromClient', 'createFromQuotation', 'createFromOrder'];

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

	public function createFromQuotation(int|string $quotation)
	{
		$quotationClass = config('products.models.quotation.class');

		$quotation = $quotationClass::find($quotation);

		$client = $quotation->client;

		$destination = $this->getModelClass()::make();
		$destination->client_id = $client->getKey();
		$destination->venue = true;
		$destination->name = 'New Venue for ' . $quotation->getName();
		$destination->save();

		$quotation->destination_id = $destination->getKey();
		$quotation->save();

		Ukn::s(__('clients::destinations.createdForClient', ['client' => $client->getName()]));

		return redirect()->to($destination->getEditUrl());
	}

	public function createFromOrder(int|string $order)
	{
		$orderClass = config('products.models.order.class');

		$order = $orderClass::find($order);

		$client = $order->client;

		$destination = $this->getModelClass()::make();
		$destination->client_id = $client->getKey();
		$destination->venue = true;
		$destination->name = 'New Venue for ' . $order->getName();
		$destination->save();

		$order->destination_id = $destination->getKey();
		$order->save();

		Ukn::s(__('clients::destinations.createdForClient', ['client' => $client->getName()]));

		return redirect()->to($destination->getEditUrl());
	}

	public function show(string $destination)
	{
		$destination = $this->findModel($destination);

		return $this->_show($destination);
	}
}
