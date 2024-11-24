<?php

namespace IlBronza\Clients\Models\Traits;

use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Destinationtype;

trait InteractsWithDestinationTrait
{
	public function legalDestination()
	{
		return $this->hasOne(
			Destination::getProjectClassName()
		)->whereHas('destinationtypeDestinations', function ($query)
		{
			$type = Destinationtype::getLegal();

			$query->where('type_slug', $type->getKey());
		});
	}

	public function defaultDestination()
	{
		return $this->hasOne(
			Destination::getProjectClassName()
		)->whereHas('destinationtypeDestinations', function ($query)
		{
			$type = Destinationtype::getDefault();

			$query->where('type_slug', $type->getKey());
		});
	}

	public function destination()
	{
		return $this->belongsTo(Destination::getProjectClassName());
	}

	public function destinations()
	{
		return $this->morphToMany(
			Destination::getProjectClassName(), 'destinatable', config('clients.models.destinatable.table'),
		);
	}

	public function getDestination() : ?Destination
	{
		if (! $this->destination_id)
			return null;

		if ($this->relationLoaded('destination'))
			return $this->destination;

		return Destination::getProjectClassName()::find($this->destination_id);
	}

	public function getDefaultStreetAddressAttribute() : ?string
	{
		return $this->getDefaultDestination()?->getStreetAddress();
	}

	public function getDefaultCityAttribute() : ?string
	{
		return $this->getDefaultDestination()?->getCity();
	}

	public function getDefaultProvinceAttribute() : ?string
	{
		return $this->getDefaultDestination()?->getProvince();
	}

	public function getDefaultStateAttribute() : ?string
	{
		return $this->getDefaultDestination()?->getState();
	}
}