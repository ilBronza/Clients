<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;

class ReferenttypeReferent extends BaseModel
{
	static $configKey = 'clients.models.referenttypeReferent';

	public function getTable()
	{
		return config(static::$configKey . '.table');
	}

}