<?php

namespace IlBronza\Clients\Models;

use IlBronza\Addresses\Models\Address;
use IlBronza\Addresses\Models\Traits\InteractsWithAddressesTrait;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Models\Casts\ExtraField;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDBrotherhoodTrait;
use IlBronza\CRUD\Traits\Model\CRUDModelExtraFieldsTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Destination extends BaseModel
{
	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'destination';
	static $deletingRelationships = [
		'address',
		'destinationtypeDestinations',
	];
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;
	use PackagedModelsTrait;

	use CRUDModelExtraFieldsTrait;
	use InteractsWithAddressesTrait;
	use CRUDUseUuidTrait;

	use CRUDSluggableTrait;

	use CRUDBrotherhoodTrait;

	protected $fillable = [
		'name',
		'address_id'
	];

	protected $casts = [
		'number' => ExtraField::class . ':address',
		'zip' => ExtraField::class . ':address',
		'town' => ExtraField::class . ':address',
		'city' => ExtraField::class . ':address',
		'province' => ExtraField::class . ':address',
		'region' => ExtraField::class . ':address',
		'state' => ExtraField::class . ':address',
		'street' => ExtraField::class . ':address',
	];

	public function getExtraFieldsClass() : ?string
	{
		return null;
	}

	public function address()
	{
		return $this->belongsTo(Address::getProjectClassName());
	}

	public function getAddressFullString() : ? string
	{
		return $this->getAddress()?->getFullString();
	}

	public function provideAddressModelForExtraFields()
	{
		if (! $this->address)
			$this->setRelation('address', $this->createDirectAddress());

		return $this->address;
	}

	public function createDirectAddress()
	{
		$this->addresses()->save($address = Address::getProjectClassName()::make());

		$this->address_id = $address->getKey();

		static::query()->where('id', $this->getKey())->update(['address_id' => $this->address_id]);

		return $address;
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
		return $this->belongsToMany(
			Referent::getProjectClassName(), config('clients.models.destinationReferent.table')
		);
	}

	public function referent()
	{
		return $this->hasOne(Referent::getProjectClassName())->where('type', config('clients.referents.default_type'));
	}

	public function getDescriptionString($separator = ' - ') : string
	{
		return "{$this->street}, {$this->number} - {$this->town} ({$this->city}) - {$this->zone}";
	}

	public function getShortDescriptionAttribute()
	{
		return $this->getShortDescriptionString();
	}

	public function getShortDescriptionString($separator = ' - ') : string
	{
		return "{$this->town} {$this->city}";
	}

	public function getTypesString() : string
	{
		$result = [];

		foreach ($this->getTypes() as $type)
			$result[] = $type->getName();

		return implode(", ", $result);
	}

	public function getTypes()
	{
		return $this->types;
	}

	public function destinationtypeDestinations()
	{
		return $this->hasMany(
			DestinationtypeDestination::getProjectClassName()
		);
	}

	public function getFlatDescriptionString()
	{
		return "{$this->name} - {$this->street}, {$this->city} ({$this->province})";
	}

	public function setName(string $name = null, bool $save = false)
	{
		return $this->_customSetter('name', $name, $save);
	}

	public function setZone(string $zone = null, bool $save = false)
	{
		return $this->_customSetter('zone', $zone, $save);
	}

	public function setAsLegal()
	{
		$type = Destinationtype::getLegal();

		$this->assignType($type);
		$this->removeTypeFromBrothers($type);
	}

	public function assignType(Destinationtype $type)
	{
		$this->types()->syncWithoutDetaching($type->getKey());
	}

	//	public static function boot() {
	//
	//		parent::boot();
	//
	//		static::saved(function($model)
	//		{
	//			if(! $model->address_id)
	//			{
	//				if($address = $model->getAddress())
	//				{
	//					$model->address_id = $address->getKey();
	//					$model->saveQuietly();
	//				}
	//			}
	//		});
	//	}

	public function types()
	{
		return $this->belongsToMany(
			Destinationtype::getProjectClassName(),
			DestinationtypeDestination::make()->getTable(),
		);
	}

	public function removeTypeFromBrothers(Destinationtype $type)
	{
		$brothers = $this->getBrothers(
			'client_id'
		);

		foreach ($brothers as $brother)
			$brother->unassignType(
				$type
			);
	}

	public function unassignType(Destinationtype $type)
	{
		$this->types()->detach($type->getKey());
	}

	public function isDefault() : bool
	{
		return ! ! $this->types()->where('name', Destinationtype::getDefault()->getName())->first();
	}

	public function setAsDefault()
	{
		$type = Destinationtype::getDefault();

		$this->assignType($type);
		$this->removeTypeFromBrothers($type);
	}

	public function relationTypesSet(array $values = null)
	{
		if (is_null($values))
			return;

		if (in_array('default', $values))
			$this->removeTypeFromBrothers(Destinationtype::getDefault());

		if (in_array('legal', $values))
			$this->removeTypeFromBrothers(Destinationtype::getLegal());
	}

	public function scopeWithTypesString($query, string $separator = ' - ')
	{
		$query->addSelect([
			'types_string' => DestinationtypeDestination::selectRaw("GROUP_CONCAT(type_slug SEPARATOR '{$separator}')")->whereColumn('clients__destinations.id', 'clients__destinationtype_destinations.destination_id')
		]);
	}

	public function scopeVenue($query)
	{
		return $query->where('venue', true);
	}

	public function setTown(string $value = null, bool $save = false)
	{
		return $this->_customSetter('town', $value, $save);
	}

	// public function scopeWithTypesArray($query, string $separator = ' ; ')
	// {
	// 	$query->addSelect([
	// 		'types_array' => DestinationtypeDestination::selectRaw("JSON_ARRAYAGG(type_slug)")
	// 					->whereColumn('clients__destinations.id', 'clients__destinationtype_destinations.destination_id')
	// 	]);
	// }

}