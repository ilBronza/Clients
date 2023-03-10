<?php

namespace IlBronza\Clients\Models;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Clients\Models\Destination;
use IlBronza\Clients\Models\Referent;

class Client extends BaseModel
{
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;


	public function destinations()
	{
		return $this->hasMany(Destination::class);
	}

	public function referents()
	{
		return $this->hasMany(Referent::class);
	}

	public function getCreateDestinationButton() : Button
	{
        return Button::create([
            'href' => route('clients.destinations.create', ['client' => $this]),
            'text' => trans('destinations.create'),
            'icon' => 'location'
        ]);
	}

	public function getCreateReferentButton() : Button
	{
        return Button::create([
            'href' => route('clients.referents.create', ['client' => $this]),
            'text' => trans('referents.create'),
            'icon' => 'user'
        ]);
	}

}