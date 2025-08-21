<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Destination;

use IlBronza\Datatables\DatatablesFields\DatatableFieldFlat;

class DatatableFieldZone extends DatatableFieldFlat
{
	public function transformValue($value)
	{
		return $value?->zone;
	}
}