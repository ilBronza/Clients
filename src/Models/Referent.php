<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;

class Referent extends BaseModel
{
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	public function destination()
	{
		return $this->belongsTo(config('clients.destination.class'));
	}

	public function destinations()
	{
		return $this->belongsToMany(config('clients.destination.class'));
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}