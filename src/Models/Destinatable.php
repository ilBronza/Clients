<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Destinatable extends BaseModel
{
	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'destinatable';
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	use PackagedModelsTrait;
	use CRUDUseUuidTrait;
}
