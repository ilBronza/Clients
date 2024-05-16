<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseDestroyableModel;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class DestinationtypeDestination extends BaseDestroyableModel
{
	public ? string $translationFolderPrefix = 'clients';
	use ClientsPackageBaseModelTrait;

	static $modelConfigPrefix = 'destinationtypeDestination';

	static $deletingRelationships = [];

}