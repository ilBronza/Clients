<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseDestroyableModel;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class ReferenttypeReferent extends BaseDestroyableModel
{
	use ClientsPackageBaseModelTrait;

	static $modelConfigPrefix = 'referenttypeReferent';
}