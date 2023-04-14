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

	static $deletingRelationships = [];

	public function getName()
	{
		return $this->second_name . " " . $this->first_name;
	}

	public function getTable()
	{
		return config('clients.models.referent.table');
	}

	public function destination()
	{
		return $this->belongsTo(config('clients.destination.class'));
	}

	public function destinations()
	{
		return $this->belongsToMany(config('clients.destination.class'), config('clients.destinationReferent.table'));
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}