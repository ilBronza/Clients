<?php

namespace IlBronza\Clients\Http\Controllers\Clienthashes;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Clienthash;
use IlBronza\CRUD\CRUD;
use Illuminate\Http\Request;
use IlBronza\Clients\Providers\Helpers\ClientHashHelper;

use function config;

class CrudClienthashCreateController extends CRUD
{
	public $allowedMethods = ['send'];

	public function setModelClass()
	{
		$this->modelClass = Clienthash::gpc();
	}

	public function validateRequest(Request $request)
	{
		return $request->validate(['ids' => 'array|required|exists:' . config('clients.models.client.table') . ',id']);
	}

	public function send(Request $request)
	{
		$parameters = $this->validateRequest($request);

		$clients = Client::gpc()::whereIn('id', $parameters['ids'])->get();

		foreach($clients as $client)
		{
			$hash = config('clients.models.clienthash.helpers.creator')::sendByCompany($client);

			dd($hash);
			dd($client);
		}

		dd($clients);

		dd($parameters);
	}
}

