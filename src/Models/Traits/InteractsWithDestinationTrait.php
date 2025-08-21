<?php

namespace IlBronza\Clients\Models\Traits;

use IlBronza\Addresses\Models\Address;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Destinationtype;

use function d;
use function dd;

trait InteractsWithDestinationTrait
{
	public function createDestination() : Destination
	{
		$destination = $this->destinations()->make([
			'name' => $this->getName()
		]);

		$destination->save();

		return $destination;
	}

	private function createDefaultDestination()
	{
		$destination = $this->createDestination();

		$destination->setAsDefault();

		return $destination;
	}

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

	public function provideAddressModelForExtraFields() : Address
	{
		if ($this->address)
			return $this->address;

		if(! $destination = $this->getDefaultDestination())
			$destination = $this->createDefaultDestination();

		if($address = $destination->getAddress())
			return $address;

		dd('creare address per la default destination');
	}

	public function scopeWithDefaultDestinationId($query)
	{
		$query->addSelect([
			'live_default_destination_id' => Destination::gpc()::select('id')
				->whereColumn('client_id', $this->getTable() . '.id')
				->whereHas('destinationtypeDestinations', function ($_query)
				{
					$_query->where('type_slug', Destinationtype::getDefault());
				})
				->take(1)
				]);
	}

	public function getDefaultStreetAddress() : ? string
	{
		return $this->default_street_address;
	}

	public function getDefaultStreetAddressAttribute() : ?string
	{
		return $this->getDefaultDestination()?->getStreetAddress();
	}

	public function getDefaultCity() : ? string
	{
		return $this->default_city;
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