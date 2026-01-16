<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Destination;

use IlBronza\Datatables\DatatablesFields\DatatableFieldFlat;

use function class_basename;

class DatatableFieldCity extends DatatableFieldFlat
{
	public function transformValue($value)
	{
		if(! $value)
			return null;

		if(class_basename($value) == 'Destination')
			return $value->getCityString();

		if (array_key_exists('live_destination_city', $value->getAttributes()))
			return $value->live_destination_city;

		if ($value->relationLoaded('destination'))
			return $value->destination->getCityString();

		if ($destination = $value->getDestination())
			return $destination->getCityString();

		return $value?->getCity();
	}
}