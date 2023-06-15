<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;

class Clienthash extends BaseModel
{
	static $modelConfigPrefix = 'clienthash';

	protected $keyType = 'string';

	protected $dates = [
		'valid_to',
		'used_at'
	];

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;

	public function client()
	{
		return $this->belongsTo(Client::getProjectClassName());
	}

	public function getClient() : Client
	{
		return $this->client;
	}
}