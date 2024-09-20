<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Traits\Model\CRUDModelTrait;
use IlBronza\CRUD\Traits\Model\CRUDRelationshipModelTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DestinationtypeDestination extends Pivot
{
//	use CRUDModelTrait;
	use CRUDRelationshipModelTrait;

	use CRUDUseUuidTrait;
	use ClientsPackageBaseModelTrait;

	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'destinationtypeDestination';
	protected $keyType = 'string';

	use PackagedModelsTrait;
//	{
//		PackagedModelsTrait::getRouteBaseNamePrefix insteadof CRUDModelTrait;
//		PackagedModelsTrait::getPluralTranslatedClassname insteadof CRUDModelTrait;
//		PackagedModelsTrait::getTranslatedClassname insteadof CRUDModelTrait;
//	}

	static $deletingRelationships = [];
}