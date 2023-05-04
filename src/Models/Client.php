<?php

namespace IlBronza\Clients\Models;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Referent;
use Illuminate\Support\Facades\Log;

class Client extends BaseModel
{
	static $modelConfigPrefix = 'client';

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	public function getRouteBaseNamePrefix() : ? string
	{
		return config('clients.routePrefix');
	}

	public function destinations()
	{
		return $this->hasMany(Destination::getProjectClassName());
	}

	public function getDestinations(array $relations = [])
	{
		Log::error('cachare questo e verificare in caso di modifica cliente se decachato');

		return $this->destinations()->with($relations)->get();
	}

	public function createDestination()
	{
		$destination = Destination::getProjectClassName()::make();
		$destination->name = $this->getName();

		$this->destinations()->save($destination);

		return $destination;
	}

	public function referents()
	{
		return $this->hasMany(Referent::getProjectClassName());
	}

	public function getCreateDestinationButton() : Button
	{
        return Button::create([
            'href' => route(config('clients.routePrefix') . 'clients.destinations.create', ['client' => $this]),
            'text' => trans('destinations.create'),
            'icon' => 'location'
        ]);
	}

	public function getCreateReferentButton() : Button
	{
        return Button::create([
            'href' => route(config('clients.routePrefix') . 'clients.referents.create', ['client' => $this]),
            'text' => trans('referents.create'),
            'icon' => 'user'
        ]);
	}

	public function getReferentsByTypes(array $types)
	{
		$types = Referenttype::whereIn('name', $types)->get();

		$referentsByTypesIds = ReferenttypeReferent::whereIn('type_slug', $types->pluck('slug'))->select('referent_id')->get();

		return $this->referents()->whereIn('id', $referentsByTypesIds)->get();
	}

}