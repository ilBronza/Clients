<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\PackagedBaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class Type extends PackagedBaseModel
{
	public ? string $translationFolderPrefix = 'clients';
	public $incrementing = false;
	protected $keyType = 'string';
	protected $primaryKey = 'slug';

	protected $fillable = ['name'];

	use CRUDSluggableTrait;

	public function getForeignKey()
	{
		return 'type_slug';
	}

	static function getDefaultName()
	{
		return config('clients.models.' . static::getModelConfigPrefix() . '.defaultName');
	}

	static function getLegalName()
	{
		return config('clients.models.' . static::getModelConfigPrefix() . '.legalName');
	}

	static function getDefault() : ? static
	{
		return cache()->remember(
			static::staticCacheKey('default'),
			3600,
			function()
			{
				if ($default = static::where('name', static::getDefaultName())->first())
					return $default;

				return static::create(['name' => static::getDefaultName()]);
			}
		);
	}

	static function getLegal() : ? static
	{
		return cache()->remember(
			static::staticCacheKey('legal'),
			3600,
			function()
			{
				return static::where('name', static::getLegalName())->first();
			}
		);
	}
}