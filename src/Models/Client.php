<?php

namespace IlBronza\Clients\Models;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Clienthash;
use IlBronza\Clients\Models\ClientsPackageBaseModelTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referent;
use IlBronza\Clients\Models\Traits\Client\ClientRelationsTrait;
use IlBronza\Ukn\Facades\Ukn;
use Illuminate\Support\Facades\Log;

class Client extends BaseModel
{
	static $modelConfigPrefix = 'client';

	protected $keyType = 'string';

	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;

	use ClientRelationsTrait;

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
		// Log::error('cachare questo e verificare in caso di modifica cliente se decachato');

		return $this->destinations()->with($relations)->get();
	}

	private function assignRandomDestinationAsDefault() : Destination
	{
		$destination = $this->destinations->first();
		$destination->setAsDefault();

		Ukn::w(_('clients::destinations.setAsDefaultBySystem', ['name' => $destination->getName()]));

		return $destinations;
	}

	private function createDefaultDestination()
	{
		$destination = $this->createDestination();

		$destination->setAsDefaultBySystem();

		//dd(__METHOD__);
		if(! $this->city)
			return $this->assignRandomDestinationAsDefault();

		$destination = Destination::make();

		$destination->client_id = $this->getKey();
		$destination->name = $this->getName();
		$destination->second_name = $this->rag_soc2;
		$destination->short_name = $this->getName();
		$destination->address = $this->street;
		$destination->city = $this->city;
		$destination->province = $this->province;
		$destination->zone = $this->zone;

		$destination->save();

		return $destination;
	}

	public function createDestination() : Destination
	{
		$destination = Destination::getProjectClassName()::make();
		$destination->name = $this->getName();

		$this->destinations()->save($destination);

		return $destination;
	}

	public function defaultDestination()
	{
		return $this->hasOne(
			Destination::getProjectClassName()
		)->whereHas('destinationtypeDestinations', function ($query)
		{
    		$type = Destinationtype::getDefault();

			$query->where('type_slug', $type->getKey());
		});
	}

	public function getDefaultDestination() : Destination
	{
		if($this->defaultDestination)
			return $this->defaultDestination;

		if(! $destinations = $this->destinations)
			return $this->createDefaultDestination();

		return $this->assignRandomDestinationAsDefault();
	}



	public function referents()
	{
		return $this->hasMany(Referent::getProjectClassName());
	}

	public function getReferents()
	{
		return $this->referents;
	}

	public function hashes()
	{
		return $this->hasMany(Clienthash::getProjectClassName());
	}

	public function getCreateHashButton() : Button
	{
		return Button::create([
			'href' => route(config('clients.routePrefix') . 'clients.clienthashes.create', ['client' => $this]),
			'text' => trans('clienthashes.create'),
			'icon' => 'user'
		]);
	}

	public function getCreateDestinationUrl()
	{
		return route(config('clients.routePrefix') . 'clients.destinations.create', ['client' => $this]);
	}

	public function getCreateDestinationButton() : Button
	{
		return Button::create([
			'href' => $this->getCreateDestinationUrl(),
			'text' => trans('destinations.create'),
			'icon' => 'location'
		]);
	}

	public function getCreateReferentUrl()
	{
		return route(config('clients.routePrefix') . 'clients.referents.create', ['client' => $this]);
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

	public function getVatAttribute($value)
	{
		return str_pad($value, 11, '0', STR_PAD_LEFT);
	}

	public function setVatAttribute($value)
    {
        $this->attributes['vat'] = str_pad($value, 11, '0', STR_PAD_LEFT);
    }
}