<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Type;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Destinationtype extends Type
{
	use PackagedModelsTrait;

	static $packageConfigPrefix = 'clients';
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