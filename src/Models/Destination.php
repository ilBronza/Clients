<?php

namespace IlBronza\Clients\Models;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\Traits\InteractsWithAddressesTrait;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Models\Casts\ExtraField;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\DestinationtypeDestination;
use IlBronza\Clients\Models\Referent;

class Destination extends BaseModel
{
	static $modelConfigPrefix = 'destination';

	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;

    use InteractsWithAddressesTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	protected $fillable = [
		'name'
	];

	protected $casts = [
		'street' => ExtraField::class . ':address',
		'number' => ExtraField::class . ':address',
		'zip' => ExtraField::class . ':address',
		'town' => ExtraField::class . ':address',
		'city' => ExtraField::class . ':address',
		'province' => ExtraField::class . ':address',
		'region' => ExtraField::class . ':address',
		'state' => ExtraField::class . ':address',
	];

	public function provideAddressModelForExtraFields()
	{
		if(! $this->address)
			return $this->setRelation('address', $this->address()->create());

		return $this->address;
	}

    public function getAddressModelClassName() : string
    {
    	return Address::class;
    }

	public function client()
	{
		return $this->belongsTo(Client::getProjectClassName());
	}

	public function getClient()
	{
		return $this->client;
	}

	public function referents()
	{
		return $this->hasMany(Referent::getProjectClassName());
	}

	public function referent()
	{
		return $this->hasOne(Referent::getProjectClassName())->where('type', config('clients.referents.default_type'));
	}

    public function getDescriptionString($separator = ' - ') : string
    {
        return "{$this->name}{$separator}{$this->street}, {$this->town} ({$this->city}){$separator}{$this->zone}";
    }

    public function getShortDescriptionString($separator = ' - ') : string
    {
        return "{$this->town} {$this->city}";
    }

    public function getShortDescriptionAttribute()
    {
    	return $this->getShortDescriptionString();
    }

	public function types()
	{
		return $this->belongsToMany(
			Destinationtype::getProjectClassName(),
			DestinationtypeDestination::make()->getTable()
		);
	}

	public function destinationtypeDestinations()
	{
		return $this->hasMany(
			DestinationtypeDestination::getProjectClassName()
		);		
	}

    public function setAsDefault()
    {
    	$type = Destinationtype::getDefault();

        $this->types()->associate($type);

        $this->removeTypeFromBrothers($type);
    }

}