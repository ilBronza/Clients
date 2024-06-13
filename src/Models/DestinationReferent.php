<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class DestinationReferent extends BaseModel
{
	public ? string $translationFolderPrefix = 'clients';
	static $modelConfigPrefix = 'destinationReferent';

	use ClientsPackageBaseModelTrait;

	public function referent()
	{
		return $this->hasOne(
			config('clients.models.referent.class')
		);
	}

	public function destination()
	{
		dd('qua non abbiamo una belongsTo!?!=!!??!');
		return $this->hasOne(
			config('clients.models.destination.class')
		);
	}

}