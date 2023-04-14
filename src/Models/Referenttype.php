<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\Clients\Models\Type;

class Referenttype extends Type
{
	static $configKey = 'clients.models.referenttype';

}