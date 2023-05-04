<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Type;

class Destinationtype extends Type
{
	static $modelConfigPrefix = 'destinationtype';

	public function destinations()
	{
		return $this->hasMany(Destination::getProjectClassName());
	}

}