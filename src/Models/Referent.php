<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\Traits\InteractsWithDestinationTrait;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Referent extends BaseModel
{
	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'referent';
	static $deletingRelationships = [];
	public ?string $translationFolderPrefix = 'clients';

//	use ClientsPackageBaseModelTrait;
	use PackagedModelsTrait;
	use CRUDUseUuidTrait;

	use CRUDSluggableTrait;

	use InteractsWithDestinationTrait;

	protected $keyType = 'string';

	public function getNameAttribute()
	{
		return $this->second_name . " " . $this->first_name;
	}

	public function getEmail()
	{
		return $this->email;
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

	public function scopeWithTypesString($query, string $separator = ' - ')
	{
		$query->addSelect([
			'types_string' => ReferenttypeReferent::selectRaw("GROUP_CONCAT(type_slug SEPARATOR '{$separator}')")->whereColumn('clients__referents.id', 'clients__referenttype_referents.referent_id')
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

	public function types()
	{
		return $this->belongsToMany(
			Referenttype::getProjectClassName(), ReferenttypeReferent::make()->getTable(),
		);
	}
}