<?php

namespace IlBronza\Clients\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\DestinationReferent;

class Referent extends BaseModel
{
	static $modelConfigPrefix = 'referent';

	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	static $deletingRelationships = [];

	public function getNameAttribute()
	{
		return $this->second_name . " " . $this->first_name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function destination()
	{
		return $this->belongsTo(Destination::getProjectClassName());
	}

	public function destinations()
	{
		return $this->belongsToMany(Destination::getProjectClassName(), DestinationReferent::make()->getTable());
	}

	public function client()
	{
		return $this->belongsTo(Client::getProjectClassName());
	}

	public function getClient() : Client
	{
		return $this->client;
	}

	public function types()
	{
		return $this->belongsToMany(
			Referenttype::getProjectClassName(),
			ReferenttypeReferent::make()->getTable(),
		);
	}

	public function scopeWithTypesString($query, string $separator = ' - ')
	{
		$query->addSelect([
			'types_string' => ReferenttypeReferent::selectRaw("GROUP_CONCAT(type_slug SEPARATOR '{$separator}')")
						->whereColumn('clients__referents.id', 'clients__referenttype_referents.referent_id')
		]);
	}

	public function getTypes()
	{
		return $this->types;
	}

	public function addTypes(array $types)
	{
		$this->types()->syncWithoutDetaching($types);
	}
}