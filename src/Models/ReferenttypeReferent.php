<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseDestroyableModel;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class ReferenttypeReferent extends BaseDestroyableModel
{
	use PackagedModelsTrait;
	public ? string $translationFolderPrefix = 'clients';
	static string $packageConfigPrefix = 'clients';

	// use ClientsPackageBaseModelTrait;

	static $modelConfigPrefix = 'referenttypeReferent';
}