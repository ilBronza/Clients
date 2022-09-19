<?php

namespace IlBronza\Clients\Models;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\Traits\InteractsWithAddressesTrait;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Referent;

class Destination extends BaseModel
{
    use InteractsWithAddressesTrait;

    public function getAddressModelClassName() : string
    {
    	return Address::class;
    }

	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function referents()
	{
		return $this->hasMany(Referent::class);
	}

	public function referent()
	{
		return $this->hasOne(Referent::class)->where('type', config('clients.referents.default_type'));
	}

}