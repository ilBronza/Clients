<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Destination;

use IlBronza\Datatables\DatatablesFields\DatatableFieldFlat;

class DatatableFieldCity extends DatatableFieldFlat
{
	public function transformValue($value)
	{
		return $value?->city;
	}
}