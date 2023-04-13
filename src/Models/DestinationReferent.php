<?php

namespace IlBronza\Clients\Models;

class DestinationReferent extends BaseModel
{
	public function getTable()
	{
		return config('clients.models.destinationReferent.table');
	}

	public function referent()
	{
		return $this->hasOne(
			config('clients.models.referent.class')
		);
	}

	public function destination()
	{
		return $this->hasOne(
			config('clients.models.destination.class')
		);
	}

}