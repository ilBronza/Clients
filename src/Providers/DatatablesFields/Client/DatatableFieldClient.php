<?php

namespace IlBronza\Clients\Providers\DatatablesFields\Client;

use IlBronza\Datatables\DatatablesFields\Links\DatatableFieldSeeName;

class DatatableFieldClient extends DatatableFieldSeeName
{
	public ? string $translationPrefix = 'clients::fields';
	public ? string $forcedStandardName = 'company';
}