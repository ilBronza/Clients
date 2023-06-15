<?php

namespace IlBronza\Clients\Models;

trait ClientsPackageBaseModelTrait
{
	static function getProjectClassName()
	{
		return config('clients.models.' . static::getModelConfigPrefix() . '.class');
	}

	public function getRouteBaseNamePrefix() : ? string
	{
		return config('clients.routePrefix');
	}

	static function getModelConfigPrefix()
	{
		return static::$modelConfigPrefix;
	}

	public function getTable()
	{
		return config("clients.models.{$this->getModelConfigPrefix()}.table");
	}

}