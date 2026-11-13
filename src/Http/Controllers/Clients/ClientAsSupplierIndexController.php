<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

class ClientAsSupplierIndexController extends ClientIndexController
{
	public function getModelClass() : string
	{
        return config('clients.models.client.asSupplier');
	}
}