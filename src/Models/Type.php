<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;

class Type extends BaseModel
{
	public $incrementing = false;
	protected $keyType = 'string';
	protected $primaryKey = 'slug';

	use CRUDSluggableTrait;

	static function getConfigKey()
	{
		return static::$configKey;
	}

	public function getTable()
	{
		return config(static::getConfigKey() . '.table');
	}

	static function getDefaultName()
	{
		return config(static::getConfigKey() . '.defaultName');
	}

	static function getDefault() : static
	{
		return cache()->remember(
			static::staticCacheKey('default'),
			3600,
			function()
			{
				return static::where('name', static::getDefaultName())->first();
			}
		);
	}
}