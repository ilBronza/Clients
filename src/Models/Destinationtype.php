<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Type;

class Destinationtype extends Type
{
	static $configKey = 'clients.models.destinationtype';

	public function destinations()
	{
		return $this->hasMany(Destination::getProjectClassName());
	}

}