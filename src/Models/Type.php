<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class Type extends BaseModel
{
	public $incrementing = false;
	protected $keyType = 'string';
	protected $primaryKey = 'slug';

	use ClientsPackageBaseModelTrait;
	use CRUDSluggableTrait;

	public function getForeignKey()
	{
		return 'type_slug';
	}

	static function getDefaultName()
	{
		return config('clients.models.' . static::getModelConfigPrefix() . '.defaultName');
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