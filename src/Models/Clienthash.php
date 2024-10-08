<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;

class Clienthash extends BaseModel
{
	static $modelConfigPrefix = 'clienthash';
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	protected $dates = [
		'valid_to',
		'used_at'
	];

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;

	protected $keyType = 'string';

	public function client()
	{
		return $this->belongsTo(Client::getProjectClassName());
	}

	public function getClient() : Client
	{
		return $this->client;
	}
}