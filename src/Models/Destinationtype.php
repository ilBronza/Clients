<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Type;

class Destinationtype extends Type
{
	public ? string $translationFolderPrefix = 'clients';
	static $modelConfigPrefix = 'destinationtype';

	public function destinations()
	{
		dd(__METHOD__);
		return $this->belongsToMany(
			Destination::getProjectClassName(),
			DestinationtypeDestination::getProjectClassName()->make()->getTable()
		);
	}

}