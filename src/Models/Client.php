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
	public ? string $translationFolderPrefix = 'clients';
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

	public function getDestination() : Destination
	{
		return $this->getDefaultDestination();
	}

	public function getDestinations(array $relations = [])
	{
		if($this->relationLoaded('destinations'))
			return $this->destinations;

		// Log::error('cachare questo e verificare in caso di modifica cliente se decachato');

		return $this->destinations()->with($relations)->get();
	}

	private function assignRandomDestinationAsDefault() : Destination
	{
		$destination = $this->destinations->first();
		$destination->setAsDefault();

		Ukn::w(trans('clients::destinations.setAsDefaultBySystem', ['name' => $destination->getName()]));

		return $destination;
	}

	public function createReferent(array $parameters = []) : Referent
	{
        $referent = Referent::getProjectClassName()::make();

        $referent->client_id = $this->getKey();
        $referent->first_name = $this->getName();

        foreach($parameters as $parameter => $value)
        	$referent->$parameter = $value;

        $referent->save();

        return $referent;
	}

	private function createDefaultDestination()
	{
		$destination = $this->createDestination();

		$destination->setAsDefault();

		return $destination;
	}

	public function createDestination() : Destination
	{
		$destination = $this->destinations()->make([
			'name' => $this->getName()
		]);

		$destination->save();

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

	public function legalDestination()
	{
		return $this->hasOne(
			Destination::getProjectClassName()
		)->whereHas('destinationtypeDestinations', function ($query)
		{
			$type = Destinationtype::getLegal();

			$query->where('type_slug', $type->getKey());
		});
	}

	public function getDefaultDestination() : ? Destination
	{
		if($this->defaultDestination)
			return $this->defaultDestination;

		if($this->destinations()->count() != 1)
			return null;

		if(! $destination = $this->destinations()->first())
			return $this->createDefaultDestination();

		return $this->assignRandomDestinationAsDefault();
	}

	public function getLegalDestination() : ? Destination
	{
		if($this->legalDestination)
			return $this->legalDestination;

		if(! $destination = $this->getDefaultDestination())
			return null;

		$destination->setAsLegal();

		return $destination;
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
			'text' => 'clients::clienthashes.create',
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
			'text' => 'clients::destinations.create',
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
            'text' => 'clients::referents.create',
            'icon' => 'user'
        ]);
	}

	public function createReferentByEmailTypes(string $email, array $types = [])
	{
		$referent = $this->createReferent([
			'email' => $email
		]);

		$referent->addTypes($types);
	}

	public function addEmailsToReferentTypes(array $emails, array $types)
	{
		$referents = $this->referents()->with('types')->get();

		foreach($emails as $email)

			if($referent = $referents->firstWhere('email', $email))
				$referent->addTypes($types);

			else
				$this->createReferentByEmailTypes($email, $types);
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