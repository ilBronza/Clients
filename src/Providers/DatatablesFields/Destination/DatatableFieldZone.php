<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Destination;

use IlBronza\Datatables\DatatablesFields\DatatableFieldFlat;
use Illuminate\Support\Facades\Log;

use function class_basename;

class DatatableFieldZone extends DatatableFieldFlat
{
	public function transformValue($value)
	{
		if(! $value)
			return null;

		if(class_basename($value) == 'Destination')
			return $value->getZone();

		if ($value->live_destination_zone)
			return $value->live_destination_zone;

		Log::critical('usa lo scope live destination zone. ' . request()->fullUrl());

		if ($destination = $value->getDestination())
			return $destination->zone ?? 0;

		return $value?->zone;
	}
}