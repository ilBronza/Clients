<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class ClientOperator extends BaseModel
{
	static $modelConfigPrefix = 'clientOperator';

	use ClientsPackageBaseModelTrait;

	public function client()
	{
		return $this->hasOne(
			config('clients.models.client.class')
		);
	}

	public function operator()
	{
		return $this->hasOne(
			config('clients.models.operator.class')
		);
	}

}