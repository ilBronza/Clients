<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Clienthash extends BaseModel
{
	use PackagedModelsTrait;

	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'clienthash';
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	protected $casts = [
		'valid_to' => 'datetime',
		'used_at' => 'datetime'
	];

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;

	public function client()
	{
		return $this->belongsTo(Client::gpc());
	}

	public function getClient() : ? Client
	{
		return $this->client;
	}
}