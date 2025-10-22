<?php

namespace IlBronza\Clients\Http\Controllers\Clients;

use IlBronza\Operators\Helpers\Companies\CompanySessionHelper;

class ClientAsClientIndexController extends ClientIndexController
{
	public $avoidCreateButton = true;

	public function getModelClass() : string
	{
        return config('clients.models.client.asClient');
	}
}