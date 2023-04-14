<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;

class DestinationtypeDestination extends BaseModel
{
	static $configKey = 'clients.models.destinationtypeDestination';

	public function getTable()
	{
		return config(static::$configKey . '.table');
	}

}