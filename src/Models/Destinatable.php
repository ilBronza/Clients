<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;

class Destinatable extends BaseModel
{
	static $modelConfigPrefix = 'destinatable';
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;

	protected $keyType = 'string';
}