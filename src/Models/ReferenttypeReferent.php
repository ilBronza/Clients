<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseDestroyableModel;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class ReferenttypeReferent extends BaseDestroyableModel
{
	public ? string $translationFolderPrefix = 'clients';
	use ClientsPackageBaseModelTrait;

	static $modelConfigPrefix = 'referenttypeReferent';
}