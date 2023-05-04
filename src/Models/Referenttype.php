<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Type;

class Referenttype extends Type
{
	use ClientsPackageBaseModelTrait;

	static $modelConfigPrefix = 'referenttype';

}