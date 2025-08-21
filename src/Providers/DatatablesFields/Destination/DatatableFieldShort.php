<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Destination;

use IlBronza\Datatables\DatatablesFields\DatatableFieldFlat;

class DatatableFieldShort extends DatatableFieldFlat
{
	public function transformValue($value)
	{
		return $value?->getShortDescriptionString();
	}
}