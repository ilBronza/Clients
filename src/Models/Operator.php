<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\ClientOperator;

class Operator extends BaseModel
{
	static $modelConfigPrefix = 'operator';

	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	public function clientOperators()
	{
		return $this->hasMany(ClientOperator::getProjectClassName());
	}

	public function clients()
	{
		return $this->belongsToMany(Client::getProjectClassName());
	}

	public function client()
	{
		return $this->hasOne(Client::getProjectClassName());
	}


}